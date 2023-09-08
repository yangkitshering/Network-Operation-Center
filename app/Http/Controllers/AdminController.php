<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Approval;
use Mail;
use App\Mail\Notify;
use Illuminate\Support\Facades\Session;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\Organization;
use Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserApproval;
use App\Mail\UserApprovalNotify;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\Visitor;
use App\Models\DataCenter;
use App\Models\RackList;
use App\Models\DcFocal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the pending access request list.
     */
    public function pending()
    {
        $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.status', '=', 'I')
            ->where('o.dc_id', '=', Auth::user()->dc_id)
            ->get();

        $focals = DB::table('dc_focals as f')
                ->join('users as u', 'f.user_id', 'u.id')
                ->select('f.*')
                ->where('f.dc_id', Auth::user()->dc_id)
                ->get();

        return view('pages.pending', compact('requests', 'focals'));
    }

    /**
     * Show the approved access request list.
     */
    public function approved()
    {
        if(Auth::user()->hasRole('admin')){
            $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.status', '!=', 'I')
            ->where('o.dc_id', '=', Auth::user()->dc_id)
            ->get();

        return view('pages.approve_reject', compact('requests'));

        }else if (Auth::user()->hasRole('user') && Auth::user()->is_dcfocal == 1){
            $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->join('dc_focals as f', 'f.id', 'r.focal_id')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('f.user_id', '=', Auth::user()->id)
            ->get();

            return view('pages.pending_exit', compact('requests'));
        }
    }

    /**
     * Admin Approve/Reject/view the request
     */
    public function processRequest($id, Request $request)
    {
        $mail_data = [
            'title'=> '',
            'body'=> ''
        ];

        $registration = Registration::where('id', $request->reg_id)->first();
        $requester_name = $registration->name;
        $dc_focal = DcFocal::where('id', $request->focal_id)->first();
        if($request->flag == 1){
           //Approve
           $mail_data['body'] = 'Your access request is approved. Please refer details in the attached document.';
           $registration->status = 'A';
           $registration->focal_id = $dc_focal->id;
           $msg = 'Access request has been approved';
           $sms = 'Your access request has been approved. For more please contact '.$dc_focal->focal_contact;
           $registration->save();  
           $title = 'Approved';
           $icon = 'success';

           $additional_user = DB::table('visitors')
           ->select('visitors.*')
           ->where('visitors.reg_id', '=', $registration->id)
           ->get();
           //PDF file part
           $org_name = DB::table('organizations')->where('id', $registration->organization)->value('org_name');
           $pdf= Pdf::loadView('pages.e_reg_card', compact('registration', 'org_name', 'additional_user', 'dc_focal'));
           $pdfFileName = 'eRegistration_' . $requester_name . '_' . time() . '.pdf'; // Generate a unique name
           $pdf->save(storage_path('app/public/' . $pdfFileName)); // Save with the unique name

           //send sms to dc focal
           $f_sms = 'You are assigned as focal to '.$org_name.'.'.'Kindly assist them to the NOC server and mark EXIT through the system on completing.';
           $f_contact = "975".$dc_focal->focal_contact;
           $this->sendSMS($f_sms, $f_contact);

        }else{
            //Reject
            $mail_data['body'] = 'Your access request is rejected due to '.$request->rejectReason.'.' .' Please submit access request again.';
            $registration->status = 'R';
            $registration->reject_reason = $request->rejectReason;
            $msg = 'Access request has been rejected';
            $sms = 'Your access request has been rejected due to '.$request->rejectReason.'.'. 'For more please contact nnoc@bt.bt or 17171717';
            $registration->save(); 
            $title = 'Rejected';
            $icon = 'error';
            $pdfFileName = '';
        }

            $mail_data['title'] = 'Hello '.$requester_name. ',';
            $eReg_Card_path = '/public/'.$pdfFileName;
            
            $notify_email = $registration->email;
            $status = $registration->status;
            Mail::to($notify_email)->send(new Notify($mail_data, $eReg_Card_path, $status, $id));

            //SMS to user
            $to = "975". $registration->contact;
            $this->sendSMS($sms, $to);
             
            Session::flash('success', $msg);
           // return redirect('dashboard');
        return redirect()->back()->with(['title'=> $title, 'icon'=> $icon]);
    }

    /**
     * load user edit page.
     */
    public function edit_user($id){  
        if($id == auth()->user()->id) {
            abort(403, 'Access Denied');
        } else {
            $user = User::find($id); 

            $organizations = DB::table('organizations')
            ->join('users', 'users.organization', '=', 'organizations.id')
            ->select('organizations.*')
            ->where('users.id', '=', $id)
            ->get();

            $cid_files = DB::table('c_i_d_files')
                    ->select('c_i_d_files.*')
                    ->where('c_i_d_files.user_id', '=', $id)
                    ->get();
                    
        return view('admin.user-edit', compact('user', 'cid_files', 'organizations'));
        }
    }

    // method to Update User
    public function update_user(Request $request, $id)
    {
        $usr = User::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'cid' => ['required', 'string', 'max:11'],
            'organization' => 'required',
            'contact' => ['required', 'max:8'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

            $usr->update([
                    'name' => $request->name,
                    'cid' => $request->cid,
                    'organization' => $request->organization,
                    'contact' => $request->contact,
                    'email' => $request->email,  
            ]);

            // Detaching Role Before Assigning The Updated Role
            if($usr->hasRole('user')) { $usr->detachRole('user'); } else { $usr->detachRole('admin'); }

            // Updating the Role
            User::find($id)->attachRole($request->roletype);

            $msg = 'User updated successfully.';
            Session::flash('success', $msg);
            // return redirect('manage_users');
        return redirect()->back();
    }

     /**
     * view individual user.
     */
    public function view_user($id)
    {
        $organizations = DB::table('organizations')
            ->join('users', 'users.organization', '=', 'organizations.id')
            ->select('organizations.*')
            ->where('users.id', '=', $id)
            ->get();

            $cid_files = DB::table('c_i_d_files')
                ->select('c_i_d_files.*')
                ->where('c_i_d_files.user_id', '=', $id)
                ->get();
           
        $user = User::where('id', '=', $id)->get()->first();

        return view('admin.user_view', compact('user','cid_files','organizations'));
    }

    //method to approve and reject user request
    public function user_approve_reject($id, Request $request){

        $mail_data = [
            'title'=> '',
            'body'=> ''
        ];
        if($request->flag == 1){
            //Approve
            $usr = User::where('id', $id)->first();
            $name = $usr->name;
            $mail_data['body'] = 'Your registration request is approved.';
            $usr->verified = 1;
            $msg = 'New user approved successfully.'; 

            if($usr->user_ref_id != 0){
                $usr->status = 'N';
            }else{
                $usr->status = 'A';
            }
            //change status to verified to add user table
            DB::table('user_adds')
                ->where('user_id', $id)
                ->update(['verified' => true,
                           'status' => 'A' 
                        ]);

            $usr->save(); 

            $title = 'Approved';
            $icon = 'success';
            $sms = 'Your registration has been approved. For more please contact nnoc@bt.bt or 17171717';
         }else{
             //Reject
            $usr = User::where('id', $request->user_id)->first();
            $name = $usr->name;
            $mail_data['body'] = 'Your registration request is rejected due to '. $request->rejectReason .'.'. ' Please submit registration request again.';
            $msg = 'New user request has been rejected';
            //  $usr->save(); 
            // if($usr->user_ref_id != 0){
            //change status to verified to add user table
            DB::table('user_adds')
            ->where('user_id', $usr->id)
            ->update(['verified' => false,
                      'status' => 'R']);
            // }
            $title = 'Rejected';
            $icon = 'error';
            $sms = 'Your registration has been rejected due to '. $request->rejectReason.'.'. 'For more please contact nnoc@bt.bt or 17171717';
            DB::table('users')->where('id', $usr->id)->delete();
         }

            // $org_name = DB::table('organizations')->where('id', $usr->organization)->value('org_name');
            // $file_path = DB::table('c_i_d_files')->where('user_id', $usr->id)->value('path');
            // Generate the PDF
            // $pdf= Pdf::loadView('pages.eCard', compact('usr', 'org_name', 'file_path'));
            // Save the PDF to storage
            // $pdfFileName = 'eCard_' . $usr->name . '_' . time() . '.pdf'; // Generate a unique name
            // $pdf->save(storage_path('app/public/' . $pdfFileName)); // Save with the unique name
            // $eCard_path = '/public/'.$pdfFileName;

            $mail_data['title'] = 'Hello '.$name. ',';
            $status = $usr->verified;
            Mail::to($usr->email)
            ->send(new UserApprovalNotify($mail_data, $status));

            //SMS
            $to = "975". $usr->contact;
            $this->sendSMS($sms, $to);

            Session::flash('success', $msg);

        return redirect()->back()->with(['title'=> $title, 'icon'=> $icon]);

    }

    public function pending_user(){
        $users = DB::table('users')
            ->join('organizations', 'users.organization', '=', 'organizations.id')
            ->select('users.*', 'organizations.org_name')
            ->where('users.status', '=', 'I')
            ->where('users.dc_id', '=', Auth::user()->dc_id)
            ->get();

            return view('pages.user_pending_list', compact('users'));
    }

    /**
     * Show ticket list.
     */
    public function displayTicket()
    {
        // $tickets = Ticket::all();
        $tickets = DB::table('tickets')
        ->join('organizations', 'organizations.id', '=', 'tickets.organization')
        ->select('tickets.*', 'org_name')
        ->where('organizations.dc_id', Auth::user()->dc_id)
        ->get();
        return view('pages.displayTicket', compact('tickets'));
    }

    /**
     * view individual ticket.
     */
    public function viewTicket($id)
    {
        // $ticket = Ticket::where('id', '=', $id)->get()->first();
        $ticket = DB::table('tickets')
        ->join('organizations', 'organizations.id', '=', 'tickets.organization')
        ->select('tickets.*', 'org_name')
        ->where('tickets.id', '=', $id)
        ->get()->first();
        return view('pages.viewTicket', compact('ticket'));
    }

     /**
     * view individual ticket.
     */
    public function ticketClose($id)
    {
        $ticket = Ticket::where('id', '=', $id)->get()->first();
        $ticket->status = 1;
        $ticket->save(); 

        return redirect('ticketList');
    }

    public function exit_now($id){
        DB::table('registrations')
        ->where('id', $id)
        ->update(['exited' => true,
        'updated_at' => Carbon::now(),
    ]);
    $icon = 'success';
    Session::flash('success', 'Thank you for the exit.');
    return redirect()->back()->with(['icon'=> $icon]);

    }

    //method to load app setting page
    public function setting(){
        $dataCenters = DB::table('data_centers as d')
                    ->select('d.*')
                    ->where('d.id', Auth::user()->dc_id)
                    ->get();

        $org_list = DB::table('organizations as o')
                    ->join('data_centers as d', 'o.dc_id', 'd.id')
                    ->select('o.*', 'd.dc_name')
                    ->where('o.dc_id', Auth::user()->dc_id)
                    ->get();
        $rack_list = DB::table('rack_lists as r')
                    ->join('organizations as o', 'r.org_id', 'o.id')
                    ->select('r.*', 'o.org_name')
                    ->where('o.dc_id', Auth::user()->dc_id)
                    ->get();
        $focal_list = DB::table('dc_focals as f')
                    ->join('users as u', 'f.user_id', 'u.id')
                    ->join('data_centers as d', 'f.dc_id', 'd.id')
                    ->select('f.*', 'd.dc_name')
                    ->where('f.dc_id', Auth::user()->dc_id)
                    ->get();
        

        return view('admin.setting', compact('dataCenters','org_list','rack_list', 'focal_list'));
    }

    //function to load add dc page
    public function add_dc()
    {
        return view('pages.add_dc');
    }

    /**
     * load edit page.
     */
    public function edit_dc($id){  
        $dc = DataCenter::find($id);      
    return view('pages.edit_dc', compact('dc'));
    }

    //function to save and edit data center
    public function save_dc(Request $request)
    {
        $validatedData = $request->validate([
            'dc_name' => 'required|string',
            'dc_location' => 'required|string',
        ]);
        if($request->id == null){
            $dataCenter = new DataCenter([
                'dc_name' => $validatedData['dc_name'],
                'dc_location' => $validatedData['dc_location'],
            ]);
            $msg = 'Data center added successfully!';
        }else{
            $dataCenter = DataCenter::where('id', $request->id)->first();
            $dataCenter->dc_name = $request->dc_name;
            $dataCenter->dc_location = $request->dc_location;
            $msg = 'Data center updated successfully!';
        }
        $dataCenter->save();

        return redirect()->back()->with('success', $msg);
    }

    // method to Delete dc
    public function delete_dc( $id)
    {
        DB::table('data_centers')->where('id', $id)->delete();
        return redirect('app_setting');
    }

    //function to load add organization page
    public function add_organization()
    {
        $dc_list = DB::table('data_centers as d')
                   ->select('d.*')
                   ->where('d.id', Auth::user()->dc_id)
                   ->get();

        return view('pages.add_organization', compact('dc_list'));
    }

    /**
     * load edit page.
     */
    public function edit_org($id){  

        $org = Organization::find($id); 
        $dc_list = DB::table('data_centers as d')
                   ->select('d.*')
                   ->where('d.id', Auth::user()->dc_id)
                   ->get();        
    return view('pages.edit_org', compact('dc_list', 'org'));
    }

    //function to save and edit organization
    public function save_organization(Request $request)
    {
        $validateData = $request->validate([
            'dc_id' =>'required',
            'org_name'=>'required',
            'org_address'=>'required',
        ]);
       
        if($request->id == null){
            $organization = new Organization([
                'dc_id'=>$validateData['dc_id'] ,
                'org_name'=>$validateData['org_name'] ,
                'org_address'=>$validateData['org_address'] ,
            ]);
            $msg = 'Organization added successfully!';
        }else{ //edit flag
            $organization = Organization::where('id', $request->id)->first();
            $organization->org_name = $request->org_name;
            $organization->org_address = $request->org_address;
            $organization->dc_id = $request->dc_id;
            $msg = 'Organization updated successfully!';
        }
        $organization->save();

        return redirect()->back()->with('success', $msg);
    }

    // method to Delete org
    public function delete_org( $id)
    {
        DB::table('organizations')->where('id', $id)->delete();
        return redirect('app_setting');
    }

    //function to load add rack page
    public function add_racklist()
    {
        $org_list = DB::table('organizations as o')
                    ->select('o.*')
                    ->where('o.dc_id', Auth::user()->dc_id)
                    ->get();
        return view('pages.add_racklist', compact('org_list'));
    }

    /**
     * load edit page.
     */
    public function edit_rack($id){  
        $rack = RackList::find($id);
        $org_list = DB::table('organizations as o')
                    ->select('o.*')
                    ->where('o.dc_id', Auth::user()->dc_id)
                    ->get();       
    return view('pages.edit_rack', compact('rack', 'org_list'));
    }
     
    //function to save and edit rack
    public function save_racklist(Request $request)
    {
        $validatedData = $request->validate([
            'rack_no' => 'required|string',
            'rack_name' => 'required|string',
            'desc' => 'required|string',
            'org_id' => 'required|integer',
        ]);
    
        if($request->id == null){
            $rackLists = new RackList([
                'rack_no' => $validatedData['rack_no'],
                'rack_name' => $validatedData['rack_name'],
                'desc' => $validatedData['desc'],
                'org_id' => $validatedData['org_id'],
            ]);
            $msg = 'RackList added successfully!';
        }else{
            $rackLists = RackList::where('id', $request->id)->first();
            $rackLists->rack_no = $request->rack_no;
            $rackLists->rack_name = $request->rack_name;
            $rackLists->desc = $request->desc;
            $rackLists->org_id = $request->org_id;
            $msg = 'RackList updated successfully!';
        } 
        $rackLists->save();

        return redirect()->back()->with('success', $msg);
    }

    // method to Delete rack
    public function delete_rack( $id)
    {
        DB::table('rack_lists')->where('id', $id)->delete(); 
        return redirect('app_setting');
    }

    //function to load add dc page
    public function add_focal()
    {
        $dc_list = DB::table('data_centers as d')
                   ->select('d.*')
                   ->where('d.id', Auth::user()->dc_id)
                   ->get();
        return view('pages.dc_focal', compact('dc_list'));
    }

    /**
     * load edit page.
     */
    public function edit_focal($id){  
        $focal = DcFocal::find($id);
        $dc_list = DB::table('data_centers as d')
                 ->select('d.*')
                 ->where('d.id', Auth::user()->dc_id)
                 ->get();       
    return view('pages.edit_focal', compact('focal', 'dc_list'));
    }

    //save dc focal
    public function save_focal(Request $request)
    {
        $validate = $request->validate([
            'dc_id' => 'required|integer',
            'focal_name' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class, 'regex:/^.+@.+\..+$/'],
            // 'email' => 'required|string',
            'focal_contact' => 'required|string',
        ]);
    
        if($request->id == null){
            $user = User::create([
                'name' => $request->focal_name,
                'cid' => '11000000001',
                'organization' => Auth::user()->organization,
                'dc_id' => $request->dc_id,
                'email' => $request->email,
                'contact' => $request->focal_contact,
                'verified' => 1,
                'user_ref_id' => 0,
                'status' => 'A',
                'is_dcfocal' => 1,
                'password' => Hash::make('noc@focal'),
            ]);
            $user->attachRole('user');

            $dc_focal = new DcFocal([
                'focal_name' => $validate['focal_name'],
                'focal_contact' => $validate['focal_contact'],
                'focal_email' => $validate['email'],
                'dc_id' => $validate['dc_id'],
                'user_id' => $user->id,
            ]);
            $msg = 'DC focal added successfully!';
        }else{
            $dc_focal = DcFocal::where('id', $request->id)->first();
            //update user
            $usr = User::where('id', $dc_focal->user_id)->first();
            $usr->name = $request->focal_name;
            $usr->email = $request->email;
            $usr->contact = $request->focal_contact;
            $usr->dc_id = $request->dc_id;
            $usr->save();
            //update focal
            $dc_focal->focal_name = $request->focal_name;
            $dc_focal->focal_email = $request->email;
            $dc_focal->focal_contact = $request->focal_contact;
            $dc_focal->dc_id = $request->dc_id;
            $msg = 'DC focal updated successfully!';
        }
        $dc_focal->save();

        return redirect()->back()->with('success', $msg);
    }

    // method to Delete focal
    public function delete_focal( $id)
    {
        DB::table('dc_focals')->where('id', $id)->delete();
        return redirect('app_setting');
    }

    //function to get approver list bases on DC
    public function getApprover($dc){
        return DB::table('users as u')
                    ->join('role_user', 'role_user.user_id', 'u.id')
                    ->select('u.email','u.contact')
                    ->where('u.dc_id', $dc)
                    ->where('role_user.role_id', 1)
                    ->get();
    }
    
    //function to send sms
    public function sendSMS($sms, $to){
        $kannelApiUrl = "http://dev.btcloud.bt:14001/cgi-bin/sendsms";
        $user = "tester";
        $pass = "foobar";
        Http::get($kannelApiUrl, [
            'user' => $user,
            'pass' => $pass,
            'text' => $sms,
            'to' => $to,
        ]);
    }
}

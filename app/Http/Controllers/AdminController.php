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

    // Render login page on clicking mail link.
    public function process()
    {
        return redirect('login');
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

        return view('pages.pending', compact('requests'));
    }

    /**
     * Show the approved access request list.
     */
    public function approved()
    {
        $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.status', '!=', 'I')
            ->where('o.dc_id', '=', Auth::user()->dc_id)
            ->get();

        return view('pages.approve_reject', compact('requests'));
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
        if($request->flag == 1){
           //Approve
           $mail_data['body'] = 'Your access request is approved. Please refer details in the attached document.';
           $registration->status = 'A';
           $registration->focal_name = $request->focal_person;
           $registration->focal_contact = $request->focal_contact;
           $msg = 'Access request has been approved';
           $sms = 'Your access request has been approved. For more please contact '.$request->focal_contact;
           $registration->save();  
           $title = 'Approved';

           $additional_user = DB::table('visitors')
           ->select('visitors.*')
           ->where('visitors.reg_id', '=', $registration->id)
           ->get();
           //PDF file part
           $org_name = DB::table('organizations')->where('id', $registration->organization)->value('org_name');
           $pdf= Pdf::loadView('pages.e_reg_card', compact('approval', 'org_name','additional_user'));
           $pdfFileName = 'eRegistration_' . $requester_name . '_' . time() . '.pdf'; // Generate a unique name
           $pdf->save(storage_path('app/public/' . $pdfFileName)); // Save with the unique name

        }else{
            //Reject
            $mail_data['body'] = 'Your access request is rejected due to '.$request->rejectReason.'.' .' Please submit access request again.';
            $registration->status = 'R';
            $registration->reject_reason = $request->rejectReason;
            $msg = 'Access request has been rejected';
            $sms = 'Your access request has been rejected. For more please contact nnoc@bt.bt or 17171717';
            $registration->save(); 
            $title = 'Rejected';
            $pdfFileName = '';
        }

            $mail_data['title'] = 'Hello '.$requester_name. ',';
            $eReg_Card_path = '/public/'.$pdfFileName;
            
            $notify_email = $registration->email;
            $status = $registration->status;
            Mail::to($notify_email)->send(new Notify($mail_data, $eReg_Card_path, $status, $id));

            //SMS
            $kannelApiUrl = "http://dev.btcloud.bt:14001/cgi-bin/sendsms";
            $user = "tester";
            $pass = "foobar";
            $text = $sms;
            $to = "975". $registration->contact;
            Http::get($kannelApiUrl, [
                'user' => $user,
                'pass' => $pass,
                'text' => $text,
                'to' => $to,
            ]);

            Session::flash('success', $msg);
           // return redirect('dashboard');
        return redirect()->back()->with('title', $title);
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

    // method to Delete User
    public function delete_user( $id, Request $request)
    {
        if($request->flag == 1){
            DB::table('users')->where('id', $id)->delete();
        }else{
            $user_id = DB::table('user_adds')->where('id', $id)->value('user_id');
            DB::table('users')
                ->where('id', $user_id)
                ->update(['verified' => false,
            'status'=> 'D']);

            DB::table('user_adds')->where('id', $id)->delete();
        }
        
        return redirect('manage_users');
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
            //change status to verified to add user table
            DB::table('user_adds')
                ->where('user_id', $id)
                ->update(['verified' => true,
                           'status' => 'A' 
                        ]);
            }else{
                $usr->status = 'A';
            }
            $usr->save(); 

            $title = 'Approved';
            $sms = 'Your registration has been approved. For more please contact nnoc@bt.bt or 17171717';
         }else{
             //Reject
            $usr = User::where('id', $request->user_id)->first();
            $name = $usr->name;
            $mail_data['body'] = 'Your registration request is rejected due to '. $request->rejectReason .'.'. ' Please submit registration request again.';
            $msg = 'New user request has been rejected';
            //  $usr->save(); 
            if($usr->user_ref_id != 0){
            //change status to verified to add user table
            DB::table('user_adds')
            ->where('user_id', $usr->id)
            ->update(['verified' => false,
                      'status' => 'R']);
            }
            $title = 'Rejected';
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
            $kannelApiUrl = "http://dev.btcloud.bt:14001/cgi-bin/sendsms";
            $user = "tester";
            $pass = "foobar";
            $text = $sms;
            $to = "975". $usr->contact;
            Http::get($kannelApiUrl, [
                'user' => $user,
                'pass' => $pass,
                'text' => $text,
                'to' => $to,
            ]);

            Session::flash('success', $msg);

        return redirect()->back()->with('title', $title);

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
        ->update(['exited' => true
    ]);
    Session::flash('success', 'Thank you for the exit.');
    return redirect()->back();

    }

    //method to load app setting page
    public function setting(){
        $dataCenters = DataCenter::all();
        $org_list = Organization::all();
        $org_list = DB::table('organizations as o')
                    ->join('data_centers as d', 'o.dc_id', 'd.id')
                    ->select('o.*', 'd.dc_name')
                    ->get();
        $rack_list = DB::table('rack_lists as r')
                    ->join('organizations as o', 'r.org_id', 'o.id')
                    ->select('r.*', 'o.org_name')
                    ->get();
        

        return view('admin.setting', compact('dataCenters','org_list','rack_list'));
    }

    //function to load add dc page
    public function add_dc()
    {
        return view('pages.add_dc');
    }

    //save dc
    public function save_dc(Request $request)
    {
        $validatedData = $request->validate([
            'dc_name' => 'required|string',
            'dc_location' => 'required|string',
            // Add validation rules for other fields
        ]);
    
        $dataCenter = new DataCenter([
            'dc_name' => $validatedData['dc_name'],
            'dc_location' => $validatedData['dc_location'],
            // Set other attributes
        ]);
        $dataCenter->save();
        return redirect()->back()->with('success', 'Data Center added successfully!');
    }

    //function to load add organization page
    public function add_organization()
    {
        $dc_list=DataCenter::all();
        return view('pages.add_organization', compact('dc_list'));
    }

    //save org
    public function save_organization(Request $request)
    {
        $validateData = $request->validate([
            'dc_id' =>'required',
            'org_name'=>'required',
            'org_address'=>'required',
        ]);
        $organization= new Organization([
            'dc_id'=>$validateData['dc_id'] ,
            'org_name'=>$validateData['org_name'] ,
            'org_address'=>$validateData['org_address'] ,
        ]);
        $organization->save();
        return redirect()->back()->with('success', 'Organization added successfully!');
    }

    //function to load add rack page
    public function add_racklist()
    {
        $org_list= Organization::all();
        return view('pages.add_racklist', compact('org_list'));
    }
     
    //save rack
        public function save_racklist(Request $request)
    {
        $validatedData = $request->validate([
            'rack_no' => 'required|string',
            'rack_name' => 'required|string',
            'desc' => 'required|string',
            'org_id' => 'required|integer',
            // Add validation rules for other fields
        ]);
    
        $rackLists = new RackList([
            'rack_no' => $validatedData['rack_no'],
            'rack_name' => $validatedData['rack_name'],
            'desc' => $validatedData['desc'],
            'org_id' => $validatedData['org_id'],
            // Set other attributes
        ]);
        $rackLists->save();
        return redirect()->back()->with('success', 'RackList added successfully!');
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
}

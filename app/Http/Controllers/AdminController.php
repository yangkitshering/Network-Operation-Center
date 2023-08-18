<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Approval;
use Mail;
use App\Mail\Notify;
use App\Mail\ApprovalRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Models\RackList;
use App\Models\Ticket;
use App\Models\DataCenter;
use App\Models\Organization;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserApproval;
use App\Mail\UserApprovalNotify;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserAdd;

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
     * Renders dashboard page on successful login.
     */
    public function index()
    {
        if(Auth::user()->hasRole('admin')){
            $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.status', '=', 'I')
            ->get();

            return view('dashboard', compact('requests'));
        }else{
            $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.email', '=', Auth::user()->email)
            ->get();

            return view('pages.user_request', compact('requests'));
        }     
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
            ->get();

        return view('pages.approve_reject', compact('requests'));
    }

    /**
     * view individual access request register.
     */
    public function viewRequest($id)
    {
        $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.id', '=', $id)
            ->get()->first();

            return view('pages.view', compact('requests'));
    }

    /**
     * Admin Approve/Reject/view the request
     */
    public function processRequest($id, Request $request)
    {
        $approval = Registration::where('id', $id)->first();
        $mail_data = [
            'title'=> 'Hello '.$approval->name. ',',
            'body'=> ''
        ];

        if($request->flag == 1){
           //Approve
           $mail_data['body'] = 'Your access request has been approved.';
           $approval->status = 'A';
           $msg = 'Request has been Approved';
           $approval->save();  
        }else{
            //Reject
            $mail_data['body'] = 'Your access request has been rejected.
                                  Kindly make your request next time.';
            $approval->status = 'R';
            $msg = 'Request has been Rejected';
            $approval->save(); 
        }

            $org_name = DB::table('organizations')->where('id', $approval->organization)->value('org_name');
            $pdf= Pdf::loadView('pages.e_reg_card', compact('approval', 'org_name'));
            $pdfFileName = 'eRegistration_' . $approval->name . '_' . time() . '.pdf'; // Generate a unique name
            $pdf->save(storage_path('app/public/' . $pdfFileName)); // Save with the unique name
            $eReg_Card_path = '/public/'.$pdfFileName;

            $notify_email = $approval->email;
            $status = $approval->status;
            Mail::to($notify_email)->send(new Notify($mail_data, $eReg_Card_path, $status, $id));

            Session::flash('success', $msg);
           // return redirect('dashboard');
        return redirect()->back();
    }

    /**
     * Renders admin request registration page.
     */
    public function register()
    {
        $organizations = DB::table('organizations')
        ->select('organizations.*')
        ->where('organizations.id', '=', Auth::user()->organization)
        ->get();

        $rack_lists = DB::table('rack_lists')
        ->join ('organizations', 'rack_lists.org_id', '=', 'organizations.id')
        ->select('rack_lists.*')
        ->where('rack_lists.org_id', '=', Auth::user()->organization)
        ->get();

        $dc_lists = DB::table('data_centers')
        ->join('organizations','organizations.dc_id', '=', 'data_centers.id')
        ->select('data_centers.*')
        ->where('organizations.id', '=', Auth::user()->organization)
        ->get();

        return view('pages.register', compact('rack_lists','organizations','dc_lists'));
    }

    /**
     * Save the request access registration.
     */
    public function save(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $input = $request->all();
        $input['exited'] = false;
        $input['status'] = 'I';
        $res = Registration::create($input);

        $org_name = DB::table('organizations')->where('id', $request->organization)->value('org_name');

        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'This is to notify that a new access request has been registered and needs your approval.',
            'name'=> $request->name,
            'cid'=> $request->cid,
            'org'=> $org_name,
            'purpose'=> $request->reason,
            'from' => $request->visitFrom,
            'to'=> $request->visitTo
        ];

        Mail::to('sonam.yeshi@bt.bt')
        ->cc('itservices@bt.bt')
        ->send(new ApprovalRequest($mail_data));
        
        Session::flash('success', 'Request submitted successfully.');
        return redirect()->back();
    }

    

    /**
     * load user manage page.
     */
    public function manage(){
        // $users = User::all();
        if(Auth::user()->hasRole('admin')){
            // $users = User::all();
            $users = DB::table('users')
            ->join('organizations', 'users.organization', '=', 'organizations.id')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('users.*', 'organizations.org_name', 'roles.name as role')
            ->where('users.status', '!=', 'D')
            ->get();
        }else{
            $users = DB::table('user_adds as u')
            ->join('organizations', 'u.organization', '=', 'organizations.id')
            // ->join('role_user', 'u.id', '=', 'role_user.user_id')
            // ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('u.*', 'organizations.org_name')
            ->where('u.user_ref_id', '=', Auth::user()->id)
            ->get();
        }
        return view('admin.manage', compact('users'));
    
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

    // POST :: Update User
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

            $msg = 'user updated successfully.';
            Session::flash('success', $msg);
            // return redirect('manage_users');
        return redirect()->back();
    }

    //function to load add new user page
    public function add(){
        // $organizations = Organization::all();
        $organizations = DB::table('organizations')
        ->select('organizations.*')
        ->where('organizations.id', '=', Auth::user()->organization)
        ->get();

        return view('pages.add_user', compact('organizations'));
    }

    //Saves the new user added.
    public function add_user(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'cid' => ['required', 'string', 'max:11'],
        'organization' => 'required',
        'contact' => ['required', 'max:8'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class, 'regex:/^.+@.+\..+$/'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust max file size as needed
        ],
        [
        'password.required' => 'The password field is required.',
        'password.confirmed' => 'The password confirmation does not match.',
        'email.regex' => 'The email address format is invalid.',
        'files.*.required' => 'The CID photo is required.',
        'files.*.mimes' => 'The CID photo must be a valid image or PDF file.',
        'cid.required' => 'The CID field is required.', // Error message for CID field
        ]);

        //for multiple file
        $cid = $request->cid;
        $filePaths = [];
        $i = 1;
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Generate the filename using the provided CID and the file's original extension
                $filename = $cid . '_'. $i . '.' . $file->getClientOriginalExtension();
                // $original_filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('cid_photos', $filename, 'public');
                $filePaths[] = $filePath;
                $i++;
            }
        }
        $user = User::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $request->organization,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_ref_id' => Auth::user()->id,
            'status' => 'I',
            'password' => Hash::make($request->password),
        ]);

        //save to new add user table
        UserAdd::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $request->organization,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_id' => $user->id,
            'user_ref_id' => Auth::user()->id,
            'status' => 'I'
        ]);

         // Attach CID photos to the user if any were uploaded
         if (!empty($filePaths)) {
            $user->cidPhotos()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $filePaths));
        }

        $user->attachRole('user'); // Assuming default role is 'user'

        $org_name = DB::table('organizations')->where('id', $request->organization)->value('org_name');
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'New user has registered',
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $org_name,
            'email' => $request->email,
            'contact' => $request->contact,
        ];

        Mail::to('sonam.yeshi@bt.bt')
        // ->cc('itservices@bt.bt')
        ->send(new UserApproval($mail_data));

        Session::flash('success', 'New User added successfully.');

    return redirect()->back();
    // return redirect('manage_users')->with('success', 'User added successfully.');
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

    public function user_approve_reject($id, Request $request){

        $usr = User::where('id', $id)->first();

        $mail_data = [
            'title'=> 'Hello '.$usr->name. ',',
            'body'=> ''
        ];

        if($request->flag == 1){
            //Approve
            $mail_data['body'] = 'Your user registration request has been approved by the administrator.';
            $usr->verified = 1;
            $usr->status = 'A';
            $msg = 'New user approved successfully.';
            $usr->save();  

            //change status to verified to add user table
            DB::table('user_adds')
                ->where('user_id', $id)
                ->update(['verified' => true,
                           'status' => 'A' 
                        ]);
         }else{
             //Reject
             $mail_data['body'] = 'Your user registration request has been rejected by the administrator.';
             $usr->verified = 0;
             $usr->status = 'R';
             $msg = 'New user request has been Rejected';
             $usr->save(); 

             //change status to verified to add user table
            DB::table('user_adds')
            ->where('user_id', $id)
            ->update(['verified' => false,
        'status' => 'R']);
         }

            $org_name = DB::table('organizations')->where('id', $usr->organization)->value('org_name');
            $file_path = DB::table('c_i_d_files')->where('user_id', $usr->id)->value('path');
            // Generate the PDF
            $pdf= Pdf::loadView('pages.eCard', compact('usr', 'org_name', 'file_path'));
            // Save the PDF to storage
            $pdfFileName = 'eCard_' . $usr->name . '_' . time() . '.pdf'; // Generate a unique name
            $pdf->save(storage_path('app/public/' . $pdfFileName)); // Save with the unique name
            $eCard_path = '/public/'.$pdfFileName;

            $status = $usr->verified;
            Mail::to($usr->email)
            ->send(new UserApprovalNotify($mail_data, $eCard_path, $status));

            Session::flash('success', $msg);

        return redirect()->back();

    }

    public function pending_user(){
        $users = DB::table('users')
            ->join('organizations', 'users.organization', '=', 'organizations.id')
            ->select('users.*', 'organizations.org_name')
            ->where('users.status', '=', 'I')
            ->get();

            return view('pages.user_pending_list', compact('users'));
    }

    // DELETE :: Delete User
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
     * Show ticket list.
     */
    public function displayTicket()
    {
        $tickets = Ticket::all();
        return view('pages.displayTicket', compact('tickets'));
    }

    /**
     * view individual ticket.
     */
    public function viewTicket($id)
    {
        $ticket = Ticket::where('id', '=', $id)->get()->first();
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
}

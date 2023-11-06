<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\User;
use App\Models\UserAdd;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserApproval;
use Illuminate\Support\Facades\Http;

class CommonController extends Controller
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

            return view('dashboard');
        }else if(Auth::user()->hasRole('user') && Auth::user()->is_dcfocal == 0){
            $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.requester_ref', '=', Auth::user()->id)
            ->get();

            return view('pages.user_request', compact('requests'));
        }else{
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

        $visitors = DB::table('visitors')
        ->select('visitors.*')
        ->where('visitors.reg_id', '=', $id)
        ->get();

        $focals = DB::table('dc_focals as f')
                ->join('users as u', 'f.user_id', 'u.id')
                ->select('f.*')
                ->where('f.dc_id', Auth::user()->dc_id)
                ->get();

        return view('pages.view', compact('requests', 'visitors', 'focals'));
    }

    /**
     * load user management page.
     */
    public function manage(){
        if(Auth::user()->hasRole('admin')){
            $users = DB::table('users')
            ->join('organizations', 'users.organization', '=', 'organizations.id')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('users.*', 'organizations.org_name', 'roles.name as role')   
            // ->where('users.status', '!=', 'D')
            ->where('users.dc_id', '=', Auth::user()->dc_id)
            ->get();
        }else{
            $users = DB::table('users as u')
            ->join('organizations', 'u.organization', '=', 'organizations.id')
            ->join('role_user', 'u.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('u.*', 'organizations.org_name', 'roles.name as role')
            ->where('u.user_ref_id', '=', Auth::user()->id)
            ->orWhere('u.id', Auth::user()->id)
            ->get();
        }
        return view('admin.manage', compact('users'));
    }

    //function to load add new user page
    public function add(){
        $organizations = DB::table('organizations')
        ->select('organizations.*')
        ->where('organizations.id', '=', Auth::user()->organization)
        ->get();

        return view('pages.add_user', compact('organizations'));
    }

    //method to save the added new user.
    public function add_user(Request $request)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'cid' => ['required', 'string', 'max:11'],
        'organization' => 'required',
        'contact' => ['required', 'max:8'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class, 'regex:/^.+@.+\..+$/'],
        'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust max file size as needed
        ],
        [
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
        $org = Organization::find($request->client_org);
        $user = User::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $request->client_org,
            'dc_id' => $org->dc_id,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_ref_id' => Auth::user()->id,
            'status' => 'I',
            'is_dcfocal' => 0,
            'password' => Hash::make($request->password),
        ]);

        // Attach CID photos to the user if any were uploaded
        if (!empty($filePaths)) {
            $user->cidPhotos()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $filePaths));
        }

        $user->attachRole('user');

        //save to new add user table
        $add_user = UserAdd::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'client_org' => $request->client_org,
            'organization' => $request->organization,
            'dc_id' => $org->dc_id,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_id' => $user->id,
            'user_ref_id' => Auth::user()->id,
            'status' => 'I'
        ]);

        // Attach CID photos to the user if any were uploaded
        if (!empty($filePaths)) {
            $add_user->user_add_cid()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $filePaths));
        }

        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'The below user has submitted registration request for your approval.',
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $org->org_name,
            'email' => $request->email,
            'contact' => $request->contact,
        ];

        //get approver
        $approver = $this->getApprover($org->dc_id);           
        //notify to approver           
        foreach($approver as $approve){
            Mail::to($approve->email)
            // ->cc('itservices@bt.bt')
            ->send(new UserApproval($mail_data));

            $text = "New registration request has been submitted for your approval. Please check your email.";
            $to = "975". $approve->contact;
            $this->sendSMS($text, $to);
        }

        //notify to user
        $text = 'Your registration has been sent for approval by '.$org->org_name. ' client.'.' For more please contact nnoc@bt.bt or 17171717';
        $to = "975". $request->contact;
        $this->sendSMS($text, $to);

        Session::flash('success', 'New user added successfully.');
        return redirect()->back();
        // return redirect('manage_users')->with('success', 'User added successfully.');
    }

    // method to Delete User
    public function delete_user( $id, Request $request)
    {
        $add_user_id = DB::table('user_adds')->where('user_id', $id)->value('id');
        DB::table('user_adds')
            ->where('id', $add_user_id)
            ->update(['verified' => false,
        'status'=> 'D']);

        DB::table('users')->where('id', $id)->delete();

        return redirect('manage_users');
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
    public function sendSMS($text, $to){
        $kannelApiUrl = "http://localhost:14001/cgi-bin/sendsms";
        $user = "tester";
        $pass = "foobar";
        Http::get($kannelApiUrl, [
            'user' => $user,
            'pass' => $pass,
            'text' => $text,
            'to' => $to,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Mail\ApprovalRequest;
use App\Mail\UserApproval;
use Auth;
use Mail;
use App\Models\User;
use App\Models\UserAdd;
use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
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
     * Renders ticket raise page.
     */
    public function ticket()
    {
        return view('pages.raiseTicket');
    }

    /**
     * Save the ticket.
     */
    public function saveTicket(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();
        $input['status'] = false;
        $res = Ticket::create($input);
        
        Session::flash('success', 'Your ticket has been submitted.');
        return redirect()->back();
    }

    /**
     * Renders access request registration page.
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

        $add_users = DB::table('user_adds as au')
        ->join('users as u', 'au.user_id', 'u.id')
        ->select('au.*')
        ->where('u.verified', 1)
        ->where('u.user_ref_id', '=', Auth::user()->id)
        ->get();

        $org_name = DB::table('organizations')->where('id', Auth::user()->organization)->value('org_name');

        return view('pages.register', compact('rack_lists','organizations','dc_lists', 'add_users', 'org_name'));
    }

    /**
     *  method to Save the access request registration on submit.
     */
    public function save(Request $request)
    {
        $request->validate([
            'passport_photos' => 'required|array', // Make sure to adjust the field name
            'passport_photos.*' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Adjust max file size and allowed image formats
        ],
        [
            'passport_photos.*.image' => ' Invalid file type. The passport photo must be an image file.',
            'passport_photos.*.mimes' => ' Only JPG, JPEG, and PNG files are allowed for passport photos.',
            'passport_photos.*.max' => 'The passport photo must not exceed 2MB in size.',

        ]);

        $filePaths = [];
        foreach ($request->file('passport_photos') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName(); // Adjust the filename as needed
            $filePath = $file->storeAs('passport', $filename, 'public'); // Files will be stored in the "public/passport" directory
            $filePaths[] = $filePath;
        }

        $requester_detail = User::find($request->requester);
        $input = $request->except('passport_photos'); // Remove passport_photos from the input
        $input['passport_path'] = implode(',', $filePaths); // Convert array to comma-separated string
        $input['name'] = $requester_detail->name;
        $input['cid'] = $requester_detail->cid;
        $input['email'] = $requester_detail->email;
        $input['contact'] = $requester_detail->contact;
        $input['exited'] = false;
        $input['status'] = 'I';
        $input['requester_ref'] = Auth::user()->id;

        $res = Registration::create($input);

        //to save additional visitors
        if($request->vname != null){
            $i = 0;
            foreach($request->vname as $name){
                $visitor = [
                    'name' => $request->vname[$i],
                    'cid' => $request->vcid[$i],
                    'organization' => $request->vorg[$i],
                    'client_org' => $requester_detail->organization,
                    'email' => $requester_detail->email,
                    'contact' => $requester_detail->contact,
                    'user_add_id' => 0,
                    'user_ref_id' => $request->requester,
                    'reg_id' => $res->id
                ];
                
                DB::table('visitors')->insert($visitor);
                $i++;
            }
        }

        $org_name = DB::table('organizations')->where('id', $request->organization)->value('org_name');
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'The below user has submitted access request for your approval.',
            'name'=> $requester_detail->name,
            'cid'=> $requester_detail->cid,
            'org'=> $org_name,
            'purpose'=> $request->reason,
            'from' => $request->visitFrom,
            'to'=> $request->visitTo
        ];

        Mail::to('noc@bt.bt')
        // ->cc('itservices@bt.bt')
        ->send(new ApprovalRequest($mail_data));

        //SMS
        $sms = 'Your access request has been submitted for approval. For more please contact nnoc@bt.bt or 17171717';
        $kannelApiUrl = "http://dev.btcloud.bt:14001/cgi-bin/sendsms";
        $user = "tester";
        $pass = "foobar";
        $text = $sms;
        $to = "975". $request->contact;
        Http::get($kannelApiUrl, [
            'user' => $user,
            'pass' => $pass,
            'text' => $text,
            'to' => $to,
        ]);
        
        $title = 'Submitted';
        Session::flash('success', 'Request submitted successfully.');
        return redirect()->back()->with(['title'=> $title]);
    }

    // function to load users own access request.
    public function my_request(){  
        $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.requester_ref', '=', Auth::user()->id)
            ->get();

        return view('pages.user_request', compact('requests'));
    }

    //edit added user
    public function edit_adduser($id){ 
        $user = UserAdd::where('user_id',$id)->first(); 
        
        $cid_files = DB::table('user_addcids')
                ->select('user_addcids.*')
                ->where('user_addcids.user_add_id', '=', $user->id)
                ->get();
                
        return view('pages.add_user_edit', compact('user', 'cid_files'));
    
    }

    // method to Update added user
    public function update_adduser(Request $request, $id)
    {
        $add_usr = UserAdd::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'cid' => ['required', 'string', 'max:11'],
            'organization' => 'required',
            'contact' => ['required', 'max:8'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $usr = User::find($add_usr->user_id);
            $usr->update([
                    'name' => $request->name,
                    'cid' => $request->cid,
                    'organization' => $request->client_org,
                    'contact' => $request->contact,
                    'email' => $request->email,  
            ]);

            $add_usr->update([
                'name' => $request->name,
                'cid' => $request->cid,
                'organization' => $request->organization,
                'contact' => $request->contact,
                'email' => $request->email,  
        ]);
            $msg = 'User updated successfully.';
            Session::flash('success', $msg);
        return redirect()->back();
    }

    //load focal change password page
    public function change_pwd(){
        return view('pages.change_pwd_focal');
    }

    //save changed password for dc focal user
    public function save_pwd(Request $request){
        $validData = $request->validate([
           'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ],
        [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $res = User::where('id', Auth::user()->id)->first();
        $res->password = Hash::make($validData['password']);
        $res->save();
        // $request->user()->update([
        //     'password' => Hash::make($validData['password']),
        // ])->where('id', Auth::user()->id);

        $msg = 'Password updated successfully.';
        Session::flash('success', $msg);
    return redirect()->back();
    }

}

<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Mail;
use App\Mail\UserApproval;
use Illuminate\Support\Facades\Storage;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use App\Models\UserAdd;

use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{

    // public function __construct() {
    //     $this->middleware('auth');
    // }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $organizations = DB::table('organizations as o')
               ->join('data_centers as d', 'o.dc_id', 'd.id')
               ->select('o.*', 'd.dc_name')
               ->get();

        return view('auth.register', compact('organizations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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

        $org = Organization::find($request->organization);
        $user = User::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $request->organization,
            'dc_id' => $org->dc_id,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_ref_id' => 0,
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

        //save to add_user table
        $add_user = UserAdd::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'client_org' => $request->organization,
            'dc_id' => $org->dc_id,
            'organization' => $org->org_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_id' => $user->id,
            'user_ref_id' => 0,
            'status' => 'I',
        ]);

        // Attach CID photos to the user if any were uploaded
        if (!empty($filePaths)) {
            $add_user->user_add_cid()->createMany(array_map(function ($path) {
                return ['path' => $path];
            }, $filePaths));
        }

        $user->attachRole('user');
        event(new Registered($user));
        // Auth::login($user);
        // return redirect(RouteServiceProvider::HOME);

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
        $text = "Your Registration has been sent for approval. For more please contact nnoc@bt.bt or 17171717";
        $to = "975". $request->contact;
        $this->sendSMS($text, $to);

        return redirect()->route('login')->with('message', "Your registration has been submitted for approval. Please contact nnoc@bt.bt.");
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
        $kannelApiUrl = "http://dev.btcloud.bt:14001/cgi-bin/sendsms";
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

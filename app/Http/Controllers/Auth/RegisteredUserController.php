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
use App\Mail\ApprovalRequest;
use Illuminate\Support\Facades\Storage;

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
        return view('auth.register');
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
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust max file size as needed

        ],
        [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'email.regex' => 'The email address format is invalid.',
            'file.required' => 'The CID photo is required.',
            'file.mimes' => 'The CID photo must be a valid image or PDF file.',


        ]);

        // Store the uploaded file and get the path
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $original_filename = time() . '_' . $file->getClientOriginalName();
            $cid_name = $request->cid . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('cid_photos', $cid_name, 'public');
        }


        $user = User::create([
            'name' => $request->name,
            'cid' => $request->cid,
            'organization' => $request->organization,
            'email' => $request->email,
            'contact' => $request->contact,
            'verified' => 0,
            'user_ref_id' => 0,
            'file_name' => $cid_name,
            'file_path' => $filePath,
            'password' => Hash::make($request->password),
        ]);
        $user->attachRole('user');

        event(new Registered($user));

        // // Auth::login($user);

        // // return redirect(RouteServiceProvider::HOME);
        // // return redirect('login');
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'New User approval.'
        ];

        Mail::to('sonam.yeshi@bt.bt')
        // ->cc('itservices@bt.bt')
        ->send(new ApprovalRequest($mail_data));

        return redirect()->route('login')->with('message', "Your registration has been submitted successfully for approval.");
    }
}

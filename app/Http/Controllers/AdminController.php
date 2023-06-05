<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Approval;
use Mail;
use App\Mail\Notify;
use Illuminate\Support\Facades\Session;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
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
    
    /**
     * Renders dashboard page on successful login with request approval list
     */
    public function index()
    {
        $approvals = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.status', '=', 'I')
            ->get();
        // $approvals = Registration::where('status', 'I')->get();

        return view('dashboard', compact('approvals'));
    }

    /**
     * Admin Approve/Reject/view the request
     */
    public function approve($id, Request $request)
    {
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> ''
        ];

        
        $approvals = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.id', '=', $id)
            ->get()->first();

        if($request->flag == 2){
            //View
            return view('pages.view', compact('approvals'));

        }else if($request->flag == 1){
           //Approve
           $approval = Registration::where('id', $id)->first();
           $mail_data['body'] = 'Your request for NOC server rack access has been approved.
                                You may enter the server room';
           $approval->status = 'A';
           $approval->save();  
        }else{
            //Reject
            $approval = Registration::where('id', $id)->first();
            $mail_data['body'] = 'Your request for NOC server rack access has been rejected.
                                  Kindly request next time.';
            $approval->status = 'R';
            $approval->save(); 
        }

        $notify_email = $approval->email;
        Mail::to($notify_email)->send(new Notify($mail_data));
        return redirect('dashboard');
    }

    /**
     * Renders admin request registration page.
     */
    public function register()
    {
        $rackList = RackList::all();
        return view('pages.register', compact('rackList'));
    }

    /**
     * Save the request registration made by the admin.
     */
    public function save_request(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $input = $request->all();
        $input['status'] = 'I';
        $res = Registration::create($input);

        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'The server rack access request registration needs your approval.'
        ];

        Mail::to('sonam.yeshi@bt.bt')->send(new Notify($mail_data));
        
        Session::flash('success', 'Form submitted successfully!');
        return redirect()->back();
    }

    /**
     * Show the approved request list.
     */
    public function approved()
    {
        $approvals = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.status', '!=', 'I')
            ->get();
        // $approvals = Registration::where('status', 'I')->get();

        return view('dashboard', compact('approvals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

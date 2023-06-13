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
use Auth;

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
        if(Auth::user()->hasRole('admin')){
            $requests = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.status', '=', 'I')
            ->get();

            return view('dashboard', compact('requests'));
        }else{
            $requests = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.email', '=', Auth::user()->email)
            ->get();

            return view('pages.user_request', compact('requests'));
        }     
    }

    /**
     * Show the approved request list.
     */
    public function approved()
    {
        $requests = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.status', '!=', 'I')
            ->get();
        // $approvals = Registration::where('status', 'I')->get();

        return view('pages.approve_reject', compact('requests'));
    }

    /**
     * view individual request register.
     */
    public function viewRequest($id)
    {
        $requests = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.id', '=', $id)
            ->get()->first();

            return view('pages.view', compact('requests'));
    }

    /**
     * Admin Approve/Reject/view the request
     */
    public function processRequest($id, Request $request)
    {
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> ''
        ];

        if($request->flag == 1){
           //Approve
           $approval = Registration::where('id', $id)->first();
           $mail_data['body'] = 'Your request for NOC server rack access has been approved.';
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
        $status = $approval->status;
        Mail::to($notify_email)->send(new Notify($mail_data, $status, $id));
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
    public function save(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $input = $request->all();
        $input['exited'] = false;
        $input['status'] = 'I';
        $res = Registration::create($input);

        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> 'The server rack access request needs your approval.'
        ];

        Mail::to('sonam.yeshi@bt.bt')
        ->cc('itservices@bt.bt')
        ->send(new ApprovalRequest($mail_data));
        
        Session::flash('success', 'Request submitted successfully.');
        return redirect()->back();
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

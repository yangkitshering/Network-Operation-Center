<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Approval;
use Mail;
use App\Mail\ApprovalRequest;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvals = Approval::where('status', 0)->get();

        // // $users = Table('users')->select('updated_at'->diffInHours('created_at'))->get();
        // $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 4:31:34');
        // $from = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
  
        // $diff_in_hours = $to->diffForHumans($from);
               
        // echo $diff_in_hours;
        // dd($approvals);

        return view('dashboard', compact('approvals'));
    }

    /**
     * // Update the approval status based on the request (approve/reject)
     */
    public function approve($id, Request $request)
    {
        $mail_data = [
            'title'=> 'Dear Sir/Madam,',
            'body'=> ''
        ];

        $approval = Approval::where('id', $id)->first();
        if($request->flag == 1){
            //Approve
            $mail_data['body'] = 'Your request for NOC server access has been approved.';
            $approval->status = true;
            $approval->save();  
        }else{
            //Reject
            $mail_data['body'] = 'Your request for NOC server access has been rejected.';
            $approval->status = false;
            $approval->save();
        }
        $approval_token = $approval->token;
        Mail::to('sonam.yeshi@bt.bt')->send(new ApprovalRequest($mail_data, $approval_token));
        return redirect('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

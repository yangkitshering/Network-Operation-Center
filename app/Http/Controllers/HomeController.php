<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Registration;
use Mail;
use App\Mail\ApprovalRequest;
use App\Models\RackList;
use App\Models\Feedback;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    /**
     * Display a listing of the resource.
     */
    public function feedback()
    {
        $rackList = RackList::all();
        return view('pages.feedback', compact('rackList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function saveFeedback( Request $res)
    {
        Feedback::create($res->all());
        $rackList = RackList::all();
        return redirect()->back()->with('message','Thank you for your feedback.','rackList');
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

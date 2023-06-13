<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Auth;

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
     * Save the ticket by user.
     */
    public function saveTicket(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();
        $input['status'] = false;
        $res = Ticket::create($input);
        
        Session::flash('success', 'Your Ticket has been submitted.');
        return redirect()->back();
    }

    // function to view  users own request.
    public function my_request(){
        
        $requests = DB::table('registrations')
            ->join('rack_lists', 'registrations.rack', '=', 'rack_lists.id')
            ->select('registrations.*', 'rack_lists.rack_no', 'rack_lists.rack_name')
            ->where('registrations.email', '=', Auth::user()->email)
            ->get();

        return view('pages.user_request', compact('requests'));
    }
}

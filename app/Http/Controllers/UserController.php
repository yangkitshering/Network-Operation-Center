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
        
        $requests = DB::table('registrations as r')
            ->join('rack_lists', 'r.rack', '=', 'rack_lists.id')
            ->join('organizations as o', 'o.id', '=', 'r.organization')
            ->select('r.*', 'rack_lists.rack_no', 'rack_lists.rack_name', 'o.org_name')
            ->where('r.email', '=', Auth::user()->email)
            ->get();

        return view('pages.user_request', compact('requests'));
    }
}

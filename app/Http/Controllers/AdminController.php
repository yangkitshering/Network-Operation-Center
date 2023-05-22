<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $users = DB::table('users')
            ->selectRaw('*, datediff(updated_at, created_at) as diff')
            ->get();

        // $users = Table('users')->select('updated_at'->diffInHours('created_at'))->get();
        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 4:31:34');
        $from = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
  
        $diff_in_hours = $to->diffForHumans($from);
               
        echo $diff_in_hours;

        // return view('admin.admin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

<?php

namespace App\Http\Controllers;

use Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RackList;
use App\Models\Registration;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //Displays the Landing page if not authenticated and the dashboard if authenticated.
    public function index()
    {
        if(! Auth::user()) {
            // $rackList = RackList::all();
            // return view('welcome', compact('rackList'));
            return view('welcome');
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }

    //update status on exit
    public function exit($id){
        $res = Registration::where('id', $id)->first();
        $res->visitTo = Carbon::now();
        $res->exited = 1;
        $res->save();  

        return redirect('/');
    }
}

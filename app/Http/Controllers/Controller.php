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
            return view('welcome');
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }

    // Render login page on clicking mail link.
    public function process()
    {
        return redirect('login');
    }
}

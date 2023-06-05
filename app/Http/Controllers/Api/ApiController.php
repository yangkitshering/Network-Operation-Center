<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Entry;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'empID'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>['required','string','min:5']
        ]);

        if ($validator->errors()->first('name') != "") {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->get('name')
            ]);
        }else if($validator->errors()->first('empID') != ""){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->get('empID')
            ]);
        }else if($validator->errors()->first('email') != ""){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->get('email')
            ]);
        }else if($validator->errors()->first('password') != ""){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->get('password')
            ]);
        }else{

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->attachRole('user');
            $success['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([  
                'success' => true,
                'message' => 'User Registered Successfully.',
                'token' => $success,
                'user' => $user
            ]);
        }
        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $validator->errors()
        //     ]);
        // }

        

    }

    /**
     * Display the specified resource.
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
           
            return response()->json([
                'success' => true,
                'token' => $success,
                'user' => $user,
                
            ]);
        }else {
            return response()->json([
                  'success' => false,
                  'message' => 'Invalid Email or Password',
              ]);
          }
    }

    //save entry
    public function save_entry(Request $request)
    {
            $input = $request->all();
            $input['entry_at']= Carbon::now();
            $entry = Entry::create($input);

            return response()->json([  
                'success' => true,
                'message' => 'Your Details has been recorded.',
                'entry' => $entry
            ]);
        }
        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $validator->errors()
        //     ]);
        // }

    /**
     * Update the specified resource in storage.
     */
    public function entry_update(int $id)
    {
        
        $entry = Entry::find($id);
        if($entry == null){
            return response()->json([  
                'success' => false,
                'message' => 'Please do entry scan first.',
            ]);
        }else{
            $entry->exit_at = Carbon::now();
            $entry->save();
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your exit.'
            ]);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

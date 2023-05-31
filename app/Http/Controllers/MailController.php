<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\ApprovalRequest;
use App\Models\Approval;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function index(){
        $mail_data = [
            'title'=> 'Mail from Laravel',
            'body'=> 'This is for testing approval mail'
        ];
        
        // $this->save_mail($mail_data);
        $approval_token = $this->save_mail($mail_data)->token;
        Mail::to('sonam.yeshi@bt.bt')->send(new ApprovalRequest($mail_data,$approval_token));

        dd('Email sent successfully');
    }

    private function save_mail($data){
        $mail = Approval::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'token' => Str::random(40),
            'status' => false,
        ]);
        return $mail;
    }
}

<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Mail\SignupEmail;
use App\Mail\ActivatedEmail;
use App\Mail\ProjectEmail;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{
    public  static function sendSignupEmail($username, $email, $verification_code){     
        $data = [
            'username' => $username,
            'verification_code' => $verification_code
        ]; 
        Mail::to($email)->send(new SignupEmail($data));
    }

    public static function getActivated($username, $email){
        $data = [
            'username' => $username,
            'email'    => $email
        ];
        Mail::to($email)->send(new ActivatedEmail($data));
    }

    public static function getproject($name,$start_date,$end_date,$duration,$value,$projectnumber     ){
        $data = [
            'name'          => $name,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'duration'      => $duration,
            'value'         => $value,
            'projectnumber' => $projectnumber   

            
,        ];
    // masukkkan email kepada siapa nak hantar
        Mail::to('farezche@gmail.com')->send(new ProjectEmail($data));
    }
}

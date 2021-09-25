<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserNotFoundException;
use App\Http\Controllers\MailsController;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Sub_Company;
use App\Models\Group;
use App\Models\Ldap;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Input;
use Redirect;
use Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use View;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
// TEST IMPORT 
 use App\Providers\RouteServiceProvider;
 use Illuminate\Foundation\Auth\RegistersUsers;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class RegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function landingpage() {
        return view('landing');
    }

    public function showRegistrationForm() {
        return view('register.edit');
    }

    // public function create(Request $request)
    // {
    //     return view('register.create');
    // }

   public function register(SaveUserRequest $request)
   {
        // table company
        $company = new Company;

        $company->name = $request->input('company');
        $company->save();

        // table user
        $user = new User();
      
        $user ->    company_id       = $company->id;
        $user ->    first_name       = e($request->input('first_name'));
        $user ->    last_name        = e($request->input('last_name'));
        $user ->    username         = e($request->input('username'));
        $user ->    email            = e($request->input('email'));

        // $user->     permissions      = e($request->input('permissions'));
        // check permission untuk kali pertama daftar
        // $permissions_array = $request->input('permission','{"admin":1}');

        // if (!Auth::user()->isSuperUser()) {
        //     unset($permissions_array['superuser']);
        // }
        // $user->permissions =  json_encode($permissions_array);

        if ($request->filled('password')) {
        $user->password              = bcrypt($request->input('password'));
            }  
        $user -> verification_code =sha1(time());
        $user ->save();


        
        if($user !=null){
            //   send email
            MailsController::sendSignupEmail($user->username,$user->email,$user->verification_code);
            //    show a message
            return redirect()->route('login')->with('success', trans('auth/general.signup_prompt'));
            // return redirect()->back()->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification code'));
            // return redirect()->route('login'); 
        }
        return redirect()->route('login')->with('error', trans('auth/general.signup_error'));
        // return redirect() -> back()->with(session()->flash('alert-danger ', 'Someting went wrong'));
        //show error message 
   }

   
   public function verifyUser()
   {
    $verification_code =\Illuminate\Support\Facades\Request::get('code');
    $user = User::where(['verification_code'=>$verification_code])->first();
   if($user!=null){
       $user->is_verified = 1;
       $user->save();
    //    return redirect()->route('login')->with('success', trans('Your account is verified. Please Log in '));
    //    return redirect() -> route('login')->with(session()->flash('alert-success', 'Your account has been verified.Please login'));
    //    return redirect() -> route('register.index')->with(session()->flash('alert-success', 'Your account has been verified.Please login'));
    return view('register.index');
   }
   return redirect() -> route('login')->with(session()->flash('alert-danger ', 'Invalid varification code'));

   
    }
}

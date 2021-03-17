<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Traits\CreateSlug;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use CreateSlug;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function RegisterForm() {
        return view('user.register');
    }

    public function register(Request $request) {

        $gs = GeneralSetting::first();
        if ($gs->registration == 1) {
            Toastr::error('Registration is closed by Admin.');
            Session::flash('alert', 'Registration is closed by Admin');
            return back();
        }

        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users|min:11|numeric|regex:/(01)[0-9]/',
            'password' => 'required|min:6'
        ]);

        if($request->email){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        $mobile = trim($request->mobile);
        $email = trim($request->email);
        $password = trim($request['password']);

        $username = $this->createSlug('users', $request->name, 'username');
        $username = trim($username, '-');
        $user = new User;
        $user->name = $request->name;
        $user->username = $username;
        $user->email =  $email;
        $user->mobile = $mobile;
        $user->role = 'student';
        $user->password = Hash::make($password);
        $user->email_verified_at = $gs->email_verification == 0 ? now() :NULL;
        $user->mobile_verified_at = $gs->sms_verification == 0 ? now() :NULL;
        $user->email_verification_token = $gs->email_verification == 0 ? rand(1000, 9999):NULL;
        $user->mobile_verification_token = $gs->sms_verification == 0 ? rand(1000, 9999):NULL;

        $success = $user->save();
        if($success) {

            $fieldType = ($request->email ? 'email' : 'mobile');
            $emailOrMobile = ($request->email ? $request->email : $request->mobile);

            Cookie::queue('emailOrMobile',$mobile, time() + (86400));
            Cookie::queue('password', $password, time() + (86400));

            if (Auth::attempt([$fieldType => $emailOrMobile, 'password' => $password])) {

                //insert notification in database
                Notification::create([
                    'type' => 'register',
                    'fromUser' => Auth::id(),
                    'toUser' => null,
                    'item_id' => Auth::id(),
                    'notify' => 'register new user',
                ]);
                Toastr::success('Registration in success.');
                if(Session::has('redirectLink')){
                    return redirect(Session::get('redirectLink'));
                }
                return redirect()->intended(route('user.dashboard'));
            }
        }else{
            Toastr::error('Registration failed try again.');
            return back()->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\State;
use App\Models\Student;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::id();
        $data['Order'] = Order::where('payment_method', '!=', 'pending')->where('user_id', Auth::id())->count();
        $data['OrderPending'] = Order::where('payment_method', '!=', 'pending')->where('order_status', '==', 'pending')->where('user_id', Auth::id())->count();
        $data['profile'] = User::find($user_id);
        $data['recentCourses'] = Order::with(['courseDetails:id,title,slug,price,thumbnail_image'])->where('user_id', $user_id)->orderBy('id', 'desc')->where('payment_method', '!=', 'pending')->take(7)->get();
        return view('frontend.user.dashboard')->with($data);
    }

    public function userProfile()
    {
        $data['user'] = User::find(Auth::id());
        $data['states'] = State::where('country_id', 18)->where('status', 1)->get();
        $data['cities'] = City::where('state_id', $data['user']->region )->where('status', 1)->get();
        $data['areas'] = Area::where('city_id', $data['user']->city )->where('status', 1)->get();
        return view('frontend.user.profile')->with($data);
    }

    public function profileUpdate(Request $request){
        $user_id = Auth::id();
        $request->validate([
            'name' => 'required',
            'email' => ['email','unique:users,email,'.$user_id],
            'mobile' => ['required','numeric','regex:/(01)[0-9]/','unique:users,mobile,'.$user_id],
        ]);

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->birthday= $request->birthday;
        $user->blood = $request->blood;
        $user->gender = $request->gender;
        $user->user_dsc = $request->user_dsc;
        $user->region = $request->region;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->zip_code = $request->zip_code;
        $user->address= $request->address;
        $update =$user->save();
        if($update){
            Toastr::success('Your profile update successful.');
        }else{
            Toastr::error('Sorry profile can\'t update.');
        }
        return back();
    }


    public function changePasswordForm(Request $request){
        return view('frontend.user.password-change');
    }
    public function changePassword(Request $request){
        $check = User::where('id', Auth::id())->first();
        if($check) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|confirmed:min:6'
            ]);

            $old_password = $check->password;
            if (Hash::check($request->old_password, $old_password)) {
                if (!Hash::check($request->password, $old_password)) {
                    $user = User::find(Auth::id());
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Toastr::success('Password successfully change.', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('New password cannot be the same as old password.', 'Error');
                    return redirect()->back();
                }
            } else {
                Toastr::error('Old password not match', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Sorry your password cann\'t change.', 'Error');
            return redirect()->back();
        }
    }
}

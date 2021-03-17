<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\AllClass;
use App\Models\Order;
use App\Models\Subject;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
	public function dashboard(){
        $data= [];

        
        $data['Course'] = Course::count();
        $data['CourseLesson'] = CourseLesson::count();
        $data['AllClass'] = AllClass::count();
        $data['Subject'] = Subject::count();
        $data['Category'] = Category::count();
        $data['Order'] = Order::where('payment_method', '!=', 'pending')->count();
        $data['AllStudent'] = User::where('role', 'student')->count();

        $data['popularCourse'] = Course::with('course_lessons:course_id')->orderBy('views', 'desc')->take(5)->get();
        $data['recentOrders'] = Order::where('payment_method', '!=', 'pending')->orderBy('id', 'desc')->take(5)->get();
        return view('admin.dashboard')->with($data);

    }

    public function profileEdit(){
	    return view('admin.setting.profile');
    }
    //profile update
    public function profileUpdate(Request $request){

	    $admin_id  = Auth::guard('admin')->id();
	    $request->validate([
	        'name' => 'required',
	        'username' => 'required',
	        'mobile' => 'required',
	        'email' => ['email','unique:users,email,'.$admin_id],
        ]);

	    $profile = User::find($admin_id);
        $profile->name = $request->name;
        $profile->username = $request->username;
        $profile->mobile = $request->mobile;
        $profile->email = $request->email;

        if ($request->hasFile('photo')) {
            //delete image from folder
            $image_path = public_path('assets/images/users/'. $profile->photo);
            if(file_exists($image_path) && $profile->photo){
                unlink($image_path);
            }
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('assets/images/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(250, 250);
            $image_resize->save($image_path);
            $profile->photo = $new_image_name;
        }
        $profile->save();
	    Toastr::success('Profile update success');
	    return back();
    }

    //change Password
    public function passwordChange(Request $request){
        return view('admin.setting.change-password');
    }

    //password update
    public function passwordUpdate(Request $request){
        $user_id  = Auth::guard('admin')->id();
        $check = User::find($user_id);
        if($check) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|confirmed:min:6'
            ]);

            $old_password = $check->password;
            if (Hash::check($request->old_password, $old_password)) {
                if (!Hash::check($request->password, $old_password)) {
                    $user = User::find($user_id);
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
            Toastr::error('Sorry your password can\'t change.', 'Error');
            return redirect()->back();
        }
    }

}

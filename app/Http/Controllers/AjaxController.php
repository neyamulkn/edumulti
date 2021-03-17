<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Course;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\State;
use App\Traits\CreateSlug;
use App\User;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    use CreateSlug;
    public function changeProfileImage(Request $request){
        $this->validate($request, [
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        $user = User::find(Auth::id());
        //profile image
        if ($request->hasFile('profileImage')) {
            //delete image from folder
            $getimage_path = public_path('upload/images/users/'. $user->photo);
            if(file_exists($getimage_path) && $user->photo){
                unlink($getimage_path);
            }
            $image = $request->file('profileImage');
            $new_image_name = $this->uniqueImagePath('users', 'photo', $image->getClientOriginalName());
            $image->move(public_path('upload/images/users'), $new_image_name);
            $user->photo = $new_image_name;
            $user->save();
            Toastr::success('Your profile image update success.');
            return back();
        }
        Toastr::error('Please select any image');
        return back();
    }
    //get sub category by category
    public function get_subcategory($cat_id){
    	$subcategories = Category::where('parent_id', $cat_id)->get();
        $output = '';
        if(count($subcategories)>0){
            $output .= '<option value="">Select Subcategory</option>';
            foreach($subcategories as $subcategory){
                $output .='<option '. (Session::get("subcategory_id") == $subcategory->id ? "selected" : "" ).' value="'.$subcategory->id.'">'.$subcategory->name.'</option>';
            }
        }
        echo $output;
    }

    // get childcategory by category
    public function get_subchild_category($subcat_id){
    	$subchildcategories = Category::where('subcategory_id', $subcat_id)->get();
        $output = '';
        if(count($subchildcategories)>0){
            $output .= '<option value="">Select child category</option>';
            foreach($subchildcategories as $subchildcategory){
                $output .='<option '. (Session::get("childcategory_id") == $subchildcategory->id ? "selected" : "" ).' value="'.$subchildcategory->id.'">'.$subchildcategory->name.' ('.count($subchildcategory->productsByChildCategory).')</option>';
            }
        }
        echo $output;
    }

    //get attribute by child category
    public function getAttributeByChildcategory($subcat_id){
    	$subchildcategories = Category::where('subcategory_id', $subcat_id)->get();
        $output = '';
        if(count($subchildcategories)>0){
            $output .= '<option value="">Select Subcategory</option>';
            foreach($subchildcategories as $subchildcategory){
                $output .='<option '. (old("subcategory") == $subchildcategory->id ? "selected" : "" ).' value="'.$subchildcategory->id.'">'.$subchildcategory->name.'</option>';
            }
        }
        echo $output;
    }

    // get attribute by category & sub category
    public function getAttributeByCategory($category_id){
    	$attributes = ProductAttribute::where('category_id', $category_id)->get();
    	$output = '';
    	if(count($attributes)>0){
    		$output = view('admin.product.attributedynamic-fields')->with(compact('attributes'));
    	}
    	echo $output;
    }

    // get city by state
    public function get_state($id=0){
        $states = State::where('country_id', $id)->get();
        $output = '';
        if(count($states)>0){
            $output .= '<option value="">Select state</option>';
            foreach($states as $state){
                $output .='<option value="'.$state->id.'">'.$state->name.'</option>';
            }
        }
        echo $output;
    }

    // get city by state
    public function get_city($id=0){
        $cities = City::where('state_id', $id)->get();
        $output = '';
        if(count($cities)>0){
            $output .= '<option value="">Select city</option>';
            foreach($cities as $city){
                $output .='<option value="'.$city->id.'">'.$city->name.'</option>';
            }
        }
        return $output;
    }

    // get area by city
    public function get_area($id=0){
        $areas = Area::where('city_id', $id)->get();
        $output = '';
        if(count($areas)>0){
            $output .= '<option value="">Select area</option>';
            foreach($areas as $area){
                $output .='<option value="'.$area->id.'">'.$area->name.'</option>';
            }
        }
        echo $output;
    }

    // check unique fielde
    public function checkField(Request $request){

        if($request->field == 'email' && !filter_var($request->value, FILTER_VALIDATE_EMAIL)){
            $output = [
                'status' => false,
                'msg' =>  $request->value ." is invalid email."
            ];
            return response()->json($output);
        }

        $check = DB::table($request->table)->where($request->field, $request->value)->first();
        if($check){
            $output = [
                'status' => false,
                'msg' =>  $request->field ." allready used."
            ];
        }else{
            $output = [
                'status' => true,
                'msg' =>  $request->field ." is available."
            ];
        }

        return response()->json($output);

    }

    // delete Data Common
    public function deleteDataCommon(Request $request)
    {
        $field = ($request->field) ? $request->field : 'id';
        $delete = DB::table($request->table)->where($field, $request->id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Data deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Data cannot deleted.'
            ];
        }
        return response()->json($output);
    }


    public function getMenuSourch($type){
        $getSources = [];
        $output = '';
        if($type == 'category'){
            $categories = Category::where('parent_id', '!=', null)->where('subcategory_id', null)->where('status', 1)->get();
            if(count($categories)>0){
                foreach ($categories as $source) {
                    $output .= ' <option value="'.$source->id.'">'.$source->name.'</option>';
                    if(count($source->get_subcategory)>0){

                        foreach($source->get_subcategory as $childcategory){
                            $output .= '<option value="'.$childcategory->id.'">&nbsp;&nbsp;'.$childcategory->name.'</option>';

                        }
                    }
                }
            }
        }elseif($type == 'page'){
            $getSources = Page::where('status', 1)->get();
            if(count($getSources)>0){
                foreach ($getSources as $source) {
                    $output .= ' <option value="'.$source->id.'">'.$source->title.'</option>';
                }
            }
        }else{
            $output = '';
        }
        echo $output;
    }

    //get cart details in header
    public function getCartHead()
    {
        $user_id = 0;
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $getCart = Cart::where('user_id', $user_id)->get();

        if(count($getCart)>0){
            echo view('frontend.carts.cart-head')->with(compact('getCart'));
        }else{
            echo '<h4 style="color:red;text-align: center;padding: 0px">Your cart is empty.</h4>';
        }
    }

    //suggest search keywords
    public function search_keyword(Request $request){

        $product = Course::selectRaw('title as product,slug,thumbnail_image as image');
        $keyword = request('q');
        $product->where(function ($query) use ($keyword) {
            $query->orWhere('title', 'like', '%' . $keyword . '%');
            $query->orWhere('meta_keywords', 'like', '%' . $keyword . '%');
        });
        $product = $product->take(5)->get()->toArray();
        $category = Category::selectRaw('name as category,slug, image')->where('name', 'LIKE', '%'. $request->q .'%')->take(5)->get()->toArray();
        $vendor = Vendor::selectRaw('shop_name,slug, logo as image')->where('shop_name', 'LIKE', '%'. $request->q .'%')->take(5)->get()->toArray();
        $search_result = array_merge($product, $category, $vendor);

        return $search_result;
    }

    // Status change function
    public function satusActiveDeactive(Request $request){
        $status = DB::table($request->table)->where('id', $request->id)->first();
        $field =  ($request->field) ? $request->field : 'status';
        //check number(1) or string(active)
        $value_type =  is_numeric($status->$field)  ? 1 : 'active';

        if(is_numeric($status->$field)){
            $value =  ($status->$field == 1)  ? 0 : 1;
        }else{
            $value =  ($status->$field == 'active')  ? 'deactive' : 'active';
        }
        if($status){
            if($status->$field == $value_type){
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }else{
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }
            $output = array( 'status' => true, 'message' => $field. ' update successful.');
        }else{
            $output = array( 'status' => false, 'message' => $field. ' can\'t update.!');
        }
        return response()->json($output);
    }

    // Status approve Unapprove function
    public function approveUnapprove(Request $request){
        $status = DB::table($request->table)->where('id', $request->id)->first();

        $field =  ($request->field) ? $request->field : 'status';
        //check number(1) or string(active)
        $value_type =  is_numeric($status->$field)  ? 1 : 'active';

        if(is_numeric($status->$field)){
            $value =  ($status->$field == 1)  ? 0 : 1;
        }else{
            $value =  ($status->$field == 'active')  ? 'unapprove' : 'active';
        }
        if($status){
            if($status->$field == $value_type){
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }else{
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }
            $output = array( 'status' => true, 'message' => ' Approve successful.');
        }else{
            $output = array( 'status' => false, 'message' => 'Sorry can\'t approve.!');
        }
        return response()->json($output);
    }

    // change Order Status function
    public function changeOrderStatus(Request $request){
        $status = Order::where('order_id', $request->id)->first();
        if($status){
            if($status->status == 1){
                DB::table($request->table)->where('id', $request->id)->update(['status' => 0]);
            }else{
                DB::table($request->table)->where('id', $request->id)->update(['status' => 1]);
            }
            $output = array( 'status' => true,  'message'  => 'Status update successful.');
        }else{
            $output = array( 'status' => false,  'message'  => 'Status can\'t update.!');
        }
        return response()->json($output);
    }

    //position sorting
    public function positionSorting(Request $request){

        for($i=0; $i<count($request->ids); $i++)
        {
            $sorting = DB::table($request->table);
            if(isset($request->field)){
                $sorting->where($request->field, $request->value);
            }
            $sorting->where('id', str_replace('item', '', $request->ids[$i]))->update(['position' => $i]);
        }
        echo 'Position sorting has been updated';
    }

    //get products by anyone field
    public function getCoursesByField (Request $request, $field){
        $output = '';
        $courses = Course::where($field, $request->id)->where('status', 'active')->get();
        if(count($courses)>0){
            $output .= ' <option value="">Select Course</option>';
            foreach ($courses as $source) {
                $output .= ' <option value="'.$source->id.'">'.$source->title.'</option>';
            }
        }
        echo $output;
    }




}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\HomepageSection;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class HomeController extends Controller
{

    //home page function
    public function index(Request $request)
    {
        $data = [];
        //get all homepage section
        $data['sections'] = HomepageSection::where('status', 1)->orderBy('position', 'asc')->paginate(1);
        //check ajax request
        if ($request->ajax()) {
            $view = view('frontend.homepage.homesection', $data)->render();
            return response()->json(['html'=>$view]);
        }
        return view('frontend.index')->with($data);
    }

    public function courses(Request $request, $category=null, $subcategory=null){
        $courses = Course::with(['course_lessons' => function ($query) {
            $query->where('status', 'active'); }])->where('status', 'active');
        //check search keyword
        if ($request->q) {
            $keyword = $request->q;
            $courses->where(function ($query) use ($keyword) {
                $query->orWhere('title', 'like', '%' . $keyword . '%');
                $query->orWhere('meta_keywords', 'like', '%' . $keyword . '%');
                $query->orWhere('summery', 'like', '%' . $keyword . '%');
            });
        }

        if ($category) {
            $category_slug = $category;
            $category = ($subcategory) ? $subcategory : $category;
            $category = Category::where('slug', $category)->first();
            if ($category){
                $category = $category->id;
                $courses->where(function ($query) use ($category) {
                    $query->orWhere('category_id', $category);
                    $query->orWhere('subcategory_id', $category);
                });
            }
        }

        //check ratting
        if ($request->ratting) {
            $courses->where('avg_ratting', $request->ratting);
        }


        $field = 'id'; $value = 'desc';
        if (isset($request->sortby) && $request->sortby) {
            try {
                $sort = explode('-', $request->sortby);
                if ($sort[0] == 'name') {
                    $field = 'title';
                } elseif ($sort[0] == 'price') {
                    $field = 'price';
                } elseif ($sort[0] == 'ratting') {
                    $field = 'avg_ratting';
                } else {
                    $field = 'id';
                }
                $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                $courses->orderBy($field, $value);
            }catch (\Exception $exception){}
        }
        $courses->orderBy($field, $value);

        if ($request->price) {
            if (!is_array($request->price)) { // direct url tags
                $price = explode(',', $request->price);
            } else { // filter by ajax
                $price = implode(',', $request->price);
            }
            if(!in_array('all', $price)) {
                $courses->whereIn('price_type', $price);
            }
        }

        //check perPage
        $perPage = 24;
        if (isset($request->perPage) && $request->perPage) {
            $perPage = $request->perPage;
        }
        $data['courses'] = $courses->selectRaw('courses.id,title,price,discount, duration, discount_type, courses.slug, views, thumbnail_image' )->paginate($perPage);
        //check ajax request
        if($request->filter){
            return view('frontend.courses.filter_courses')->with($data);
        }else {
            $categories = Category::where('categories.status', 1);
            if ($category) {
                $categories->where('categories.slug', $category_slug);
            }
            $data['categories'] = $categories->groupBy('categories.id')->selectRaw('categories.id,categories.name, categories.slug')->get();

            return view('frontend.courses.courses')->with($data);
        }
    }

    //display Course details by Course id/slug
    public function course_details($slug)
    {
        $data['course_details'] = Course::with(['course_lessons' => function ($query) {
            $query->where('status', '=', 'active'); }, 'course_enroll:course_id'])->where('slug', $slug)->first();
//        dd($data['course_details']);
        if($data['course_details']) {

            //recent views set category id
            $recent_catId = ($data['course_details']->subcategory_id) ? $data['course_details']->subcategory_id : $data['course_details']->category_id;
            $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
            $recentViews = array_merge([$recent_catId], $recentViews);
            $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
            Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));
            // count course views
            if(!Cookie::has('recentViews'.$data['course_details']->id)) {
                Cookie::queue('recentViews'.$data['course_details']->id, 'views', time() + (86400));
                $data['course_details']->increment('views');
            }
            $related_courses = Course::where('status', 'active');
            if($data['course_details']->childcategory_id != null){
                $category_feild = 'childcategory_id';
                $category_id = $data['course_details']->childcategory_id;
            }elseif($data['course_details']->subcategory_id != null){
                $category_feild = 'subcategory_id';
                $category_id = $data['course_details']->subcategory_id;
            }else{
                $category_feild = 'category_id';
                $category_id = $data['course_details']->category_id;
            }

            $data['related_courses'] = $related_courses->where($category_feild, $category_id)->selectRaw('id,title,slug,thumbnail_image,price,discount,discount_type,summery')->where('id', '!=', $data['course_details']->id)->take(8)->get();

            return view('frontend.courses.details')->with($data);
        }else{
            return view('404');
        }
    }

    //about Us page
    public function aboutUs(Request $request)
    {
        return view('frontend.pages.about-us');
    }
    //about Us page
    public function contactUs(Request $request)
    {
        return view('frontend.pages.contact-us');
    }

    public function page404(){
        return view('404');
    }

}

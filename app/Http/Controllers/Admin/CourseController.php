<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use CreateSlug;
    //Class list
    public function index(Request $request, $status='')
    {
        $courses = Course::with(['course_lessons' => function ($query) {
        $query->where('status', '=', 'active'); },'course_enroll:course_id'])->orderBy('id', 'desc');
        $data['courseCount'] = $courses->get();

        if($status){
            $courses->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $courses->where('status', $request->status);
        }
        if($request->category && $request->category != 'all'){
        $courses->where('category_id', $request->category);
        }
        if($request->title){
            $courses->where('title', 'LIKE', '%'. $request->title .'%');
        }
        $data['courses'] = $courses->paginate(15);


        $data['categories'] = Category::where('status', 1)->get();
        return view('admin.course.course-lists')->with($data);
    }

    //Class list
    public function create()
    {

        $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
        return view('admin.course.create-course')->with($data);
    }

    // store course
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            'thumbnail_image' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $author_id = ($request->author_id) ? $request->author_id : $user_id;
        $data = new Course();
        $data->author_id = $author_id;
        $data->title = $request->title;
        $data->slug = $this->createSlug('courses', $request->title);
        $data->summery = $request->summery;
        $data->description = $request->description;
        $data->price_type = $request->price_type;
        $data->price = $request->price;
        $data->discount = ($request->discount) ? $request->discount : null;
        $data->discount_type = ($request->discount_type) ? $request->discount_type : null;
        $data->duration = $request->duration;
        $data->category_id = $request->category;
        $data->subcategory_id = ($request->subcategory) ? $request->subcategory : null;
        $data->childcategory_id = ($request->childcategory) ? $request->childcategory : null;
        $data->class = ($request->class ? $request->class : null);
        $data->subject = ($request->subject ? $request->subject : null);
        $data->level = ($request->level ? $request->level : null);
        $data->language = ($request->language ? $request->language : null);
        $data->tags = ($request->tags) ? implode(',', $request->tags) : null;
        $data->start_date = ($request->start_date) ? $request->start_date : null;
        $data->end_date = ($request->end_date) ? $request->end_date : null;
        $data->meta_title = $request->meta_title;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = $request->meta_description;
        $data->created_by = $user_id;
        $data->approved = 1;
        $data->status = ($request->status ? 'active' : 'inactive');
        //thumbnail image
        if ($request->hasFile('thumbnail_image')) {
            $image = $request->file('thumbnail_image');
            $new_image_name = $this->uniqueImagePath('courses', 'thumbnail_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/course'), $new_image_name);
            $data->thumbnail_image = $new_image_name;
        }
        //overview video
        if($request->video_provider) {
            $data->video_provider = $request->video_provider;
            //if overview video set
            if($request->video_provider == 'video') {
                if ($request->hasFile('overview_video')) {
                    $video = $request->file('overview_video');
                    $new_video_name = $this->uniqueImagePath('courses', 'overview_video', $video->getClientOriginalName());
                    $video->move(public_path('upload/videos/course'), $new_video_name);
                    $data->overview_video = $new_video_name;
                }
            }else{
                $data->overview_video = $request->overview_video;
            }
        }

        //if meta image set
        if ($request->hasFile('meta_image')) {
            $image = $request->file('meta_image');
            $new_image_name = $this->uniqueImagePath('courses', 'meta_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/course'), $new_image_name);
            $data->meta_image = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Course Create Successfully.');
        }else{
            Toastr::error('Course Cannot Create.!');
        }
       return back();
    }

    //edit Course
    public function edit($slug)
    {
        $data['course'] = Course::where('slug', $slug)->first();
        if($data['course']) {
            $data['categories'] = Category::where('parent_id', '=', null)->where('status', 1)->get();
            $data['subcategories'] = Category::where('parent_id', '=', $data['course']->category_id)->where('status', 1)->get();
        }
        return view('admin.course.course-edit')->with($data);
    }

    //update Course
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $author_id = ($request->author_id) ? $request->author_id : $user_id;
        $data = Course::find($id);
        if(!$data){
            Toastr::error('Course Cannot Found.!');
            return back();
        }
        $data->author_id = $author_id;
        $data->title = $request->title;
        $data->summery = $request->summery;
        $data->description = $request->description;
        $data->price_type = $request->price_type;
        $data->price = $request->price;
        $data->discount = ($request->discount) ? $request->discount : null;
        $data->discount_type = ($request->discount_type) ? $request->discount_type : null;
        $data->duration = $request->duration;
        $data->category_id = $request->category;
        $data->subcategory_id = ($request->subcategory) ? $request->subcategory : null;
        $data->childcategory_id = ($request->childcategory) ? $request->childcategory : null;
        $data->class = ($request->class ? $request->class : null);
        $data->subject = ($request->subject ? $request->subject : null);
        $data->level = ($request->level ? $request->level : null);
        $data->language = ($request->language ? $request->language : null);
        $data->tags = ($request->tags) ? implode(',', $request->tags) : null;
        $data->start_date = ($request->start_date) ? $request->start_date : null;
        $data->end_date = ($request->end_date) ? $request->end_date : null;
        $data->meta_title = $request->meta_title;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = $request->meta_description;
        $data->updated_by = $user_id;
        $data->status = ($request->status ? 'active' : 'inactive');
        //thumbnail image
        if ($request->hasFile('thumbnail_image')) {
            //delete image from folder
            $getimage_path = public_path('upload/images/course/'. $data->thumbnail_image);
            if(file_exists($getimage_path) && $data->thumbnail_image){
                unlink($getimage_path);
            }
            $image = $request->file('thumbnail_image');
            $new_image_name = $this->uniqueImagePath('courses', 'thumbnail_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/course'), $new_image_name);
            $data->thumbnail_image = $new_image_name;
        }
        //overview video
        if($request->video_provider) {
            //delete video from folder
            if($data->video_provider == 'video' && $request->overview_video ) {
                $video_path = public_path('upload/videos/course/' . $data->overview_video);
                if (file_exists($video_path) && $data->overview_video) {
                    unlink($video_path);
                }
            }
            if($request->video_provider == 'video'){
                //upload new update video
                if ($request->hasFile('overview_video')) {
                    $video = $request->file('overview_video');
                    $new_video_name = $this->uniqueImagePath('courses', 'overview_video', $video->getClientOriginalName());
                    $video->move(public_path('upload/videos/course'), $new_video_name);
                    $data->overview_video = $new_video_name;
                }
            }else{
                $data->overview_video = $request->overview_video;
            }
        $data->video_provider = $request->video_provider;
        }

        //if meta image set
        if ($request->hasFile('meta_image')) {
            $getimage_path = public_path('upload/images/course/'. $data->meta_image);
            if(file_exists($getimage_path) && $data->meta_image){
                unlink($getimage_path);
            }
            $image = $request->file('meta_image');
            $new_image_name = $this->uniqueImagePath('courses', 'meta_image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/course'), $new_image_name);
            $data->meta_image = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Course update Successfully.');
        }else{
            Toastr::error('Course Cannot Update.!');
        }
        return back();
    }

    //delete Course
    public function delete($id)
    {
        $delete = Course::where('id', $id)->first();
        if($delete){
            $image_path = public_path('upload/images/class/'. $delete->photo);
            if(file_exists($image_path) && $delete->photo){
                unlink($image_path);
            }
            $delete->delete();
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}

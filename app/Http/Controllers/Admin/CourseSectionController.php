<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseSection;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseSectionController extends Controller
{
    use CreateSlug;
    public function index($slug)
    {
        $data['course'] = Course::where('slug', $slug)->first();
        if($data['course']){
            $data['course_sections'] = CourseSection::where('course_id', $data['course']->id)->orderBy('position', 'asc')->get();
            $data['deactive_sections'] = CourseSection::where('course_id', $data['course']->id)->where('status', 0)->count();
            $data['total_lesson'] = CourseLesson::where('course_id', $data['course']->id)->count();
            $data['deactive_lesson'] = CourseLesson::where('course_id', $data['course']->id)->where('status', 'deactive')->count();
            return view('admin.lessons.course_sections')->with($data);
        }
        Toastr::error('Sorry course not found.');
        return back();
    }

    public function store(Request $request, $course_id)
    {
        $request->validate([
            'section_title' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $author_id = ($request->author_id) ? $request->author_id : $user_id;
        $data = new CourseSection();
        $data->author_id = $author_id;
        $data->course_id = $course_id;
        $data->section_title = $request->section_title;
        $data->slug = $this->createSlug('course_sections', $request->section_title);
        $data->summery = $request->summery;
        $data->created_by = $user_id;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Section added successful.');
        }else {
            Toastr::erro('Section added failed.');
        }
        return back();
    }

    public function edit($id)
    {
        $data = CourseSection::find($id);
        if($data){
            return view('admin.lessons.course_section_edit')->with(compact('data'));
        }
        return false;

    }

    public function update(Request $request)
    {
        $request->validate([
            'section_title' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $author_id = ($request->author_id) ? $request->author_id : $user_id;
        $data = CourseSection::find($request->id);
        $data->section_title = $request->section_title;
        $data->summery = $request->summery;
        $data->updated_by = $user_id;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Section update successful.');
        }else {
            Toastr::erro('Section update failed.');
        }
        return back();
    }

    //delete Section
    public function delete($id)
    {
        $delete = CourseSection::find($id);
        if($delete){
            $delete->delete();
            $output = [
                'status' => true,
                'msg' => 'Section deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Section cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}

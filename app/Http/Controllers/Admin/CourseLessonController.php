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

class CourseLessonController extends Controller
{
    use CreateSlug;
    public function index()
    {
        $lessons = CourseLesson::all();
        return view('admin.lessons.lessons')->with(compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_title' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $author_id = ($request->author_id) ? $request->author_id : $user_id;
        $data = new CourseLesson();
        $data->author_id = $author_id;
        $data->course_id = $request->course_id;
        $data->section_id = $request->section_id;
        $data->lesson_title = $request->lesson_title;
        $data->slug = $this->createSlug('course_lessons', $request->lesson_title);
        $data->description = $request->description;
        $data->duration = $request->duration;
        $data->free_lesson = ($request->free_lesson) ? 1 : 0;
        $data->created_by = $user_id;
        $data->status = ($request->status ? 'active' : 'inactive');

        //overview video
        if($request->content_type) {
            $data->content_type = $request->content_type;
            //if content type set
            if ($request->hasFile('content')) {
                $video = $request->file('content');
                $new_content_name = $this->uniqueImagePath('course_lessons', 'content', $video->getClientOriginalName());
                $video->move(public_path('upload/lessons'), $new_content_name);
                $data->content = $new_content_name;
            }else{
                $data->content_link = $request->content_link;
            }
        }
        $store = $data->save();
        if($store){
            Toastr::success('Lesson added successful.');
        }else {
            Toastr::erro('Lesson added failed.');
        }
        return back();
    }

    public function edit($id)
    {
        $data = CourseLesson::find($id);
        echo view('admin.lessons.course_lesson_edit')->with(compact('data'));
    }


    public function update(Request $request, CourseLesson $courseLesson)
    {
        $request->validate([
            'lesson_title' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $data = CourseLesson::find($request->id);
        $data->lesson_title = $request->lesson_title;
        $data->description = $request->description;
        $data->duration = $request->duration;
        $data->free_lesson = ($request->free_lesson) ? 1 : 0;
        $data->updated_by = $user_id;
        $data->status = ($request->status ? 'active' : 'inactive');
        //content
        if($request->content_type) {
            //delete content from folder
            if($data->content) {
                $content_path = public_path('upload/lessons/' . $data->content);
                if (file_exists($content_path) && $data->content) {
                    unlink($content_path);
                }
            }
            //if content type set
            if ($request->hasFile('content')) {
                $video = $request->file('content');
                $new_content_name = $this->uniqueImagePath('course_lessons', 'content', $video->getClientOriginalName());
                $video->move(public_path('upload/lessons'), $new_content_name);
                $data->content = $new_content_name;
            }else{
                $data->content_link = $request->content_link;
            }
            $data->content_type = $request->content_type;
        }
        $store = $data->save();
        if($store){
            Toastr::success('Lesson update successful.');
        }else {
            Toastr::erro('Lesson update failed.');
        }
        return back();
    }

    //delete Lesson
    public function delete($id)
    {
        $delete = CourseLesson::find($id);
        if($delete){
            if($delete->content) {
                $content_path = public_path('upload/lessons/' . $delete->content);
                if (file_exists($content_path) && $delete->content) {
                    unlink($content_path);
                }
            }
            $delete->delete();
            $output = [
                'status' => true,
                'msg' => 'Lesson deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Lesson cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}

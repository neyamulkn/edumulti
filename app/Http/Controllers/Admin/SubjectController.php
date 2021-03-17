<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use CreateSlug;

    //subject list
    public function index()
    {
        $subjects = Subject::orderBy('id', 'desc')->get();
        return view('admin.academic.subject')->with(compact('subjects'));
    }

    // store Subject
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);
        $data = new Subject();
        $data->subject_name = $request->name;
        $data->slug = $this->createSlug('subjects', $request->name);
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/subject'), $new_image_name);
            $data->photo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Subject Create Successfully.');
        }else{
            Toastr::error('Subject Cannot Create.!');
        }

        return back();
    }

    //edit Subject
    public function edit($id)
    {
        $data['data'] = Subject::find($id);
        echo view('admin.academic.edit.subject')->with($data);
    }

    //update Subject
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = Subject::find($request->id);
        $data->subject_name = $request->name;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('photo')) {
            //delete image from folder
            $image_path = public_path('upload/images/subject/'. $data->logo);
            if(file_exists($image_path) && $data->logo){
                unlink($image_path);
            }
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/subject'), $new_image_name);
            $data->photo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Subject Update Successfully.');
        }else{
            Toastr::error('Subject Cannot Update.!');
        }

        return back();
    }

    //delete Subject
    public function delete($id)
    {
        $delete = Subject::where('id', $id)->first();
        if($delete){
            $image_path = public_path('upload/images/subject/'. $delete->photo);
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

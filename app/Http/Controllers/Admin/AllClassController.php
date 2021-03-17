<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllClass;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AllClassController extends Controller
{
    use CreateSlug;
    //Class list
    public function index()
    {
        $classes= AllClass::orderBy('id', 'desc')->get();
        return view('admin.academic.classes')->with(compact('classes'));
    }

    // store Class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = new AllClass();
        $data->class_name = $request->name;
        $data->slug = $this->createSlug('all_classes', $request->name);
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/class'), $new_image_name);
            $data->photo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Class Create Successfully.');
        }else{
            Toastr::error('Class Cannot Create.!');
        }

        return back();
    }

    //edit Class
    public function edit($id)
    {
        $data['data'] = AllClass::find($id);
        echo view('admin.academic.edit.classes')->with($data);
    }

    //update Class
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = AllClass::find($request->id);
        $data->class_name = $request->name;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('photo')) {
            //delete image from folder
            $image_path = public_path('upload/images/class/'. $data->logo);
            if(file_exists($image_path) && $data->logo){
                unlink($image_path);
            }
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/class'), $new_image_name);
            $data->photo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Class Update Successfully.');
        }else{
            Toastr::error('Class Cannot Update.!');
        }

        return back();
    }

    //delete Class
    public function delete($id)
    {
        $delete = AllClass::where('id', $id)->first();
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

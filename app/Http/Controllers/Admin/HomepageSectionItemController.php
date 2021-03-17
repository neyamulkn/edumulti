<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Course;
use App\Models\HomepageSection;
use App\Models\HomepageSectionItem;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HomepageSectionItemController extends Controller
{
    use CreateSlug;
    public function index($slug)
    {
        $data['categories'] = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $data['section'] = HomepageSection::where('slug', $slug)->first();
        $sectionItems = HomepageSectionItem::where('section_id', $data['section']->id);
        if($data['section']->section_type == 'course'){
            $sectionItems->with('course');
        }
        if($data['section']->section_type == 'category'){
            $sectionItems->with('category');
        }
        if($data['section']->section_type == 'banner'){
            $sectionItems->with('banner');
        }
        $data['sectionItems'] = $sectionItems->orderBy('position', 'asc')->paginate(24);

        return view('admin.homepage.sectionItem.'.$data['section']->section_type)->with($data);
    }

    //get all courses by anyone field
    public function getAllCourses(Request $request){
        $data['items_id'] = HomepageSectionItem::where('section_id', $request->section_id)->get()->pluck('item_id')->toArray();

        $item = Course::where('status', 'active');
        if ($request->course) {
            $keyword = $request->item;
            $item->Where('title', 'like', '%' . $keyword . '%');
        }
        if ($request->price && $request->price != 'all') {
            $item->where('price_type', $request->price);
        }

        if ($request->category && $request->category != 'all') {
            $item->where('category_id', $request->category);
        }
        $data['allCourses'] = $item->orderBy('title', 'asc')->paginate(25);

        return view('admin.homepage.sectionItem.getCourses')->with($data);
    }
   //get all category by anyone field
    public function getAllcategories(Request $request){
        $data['items_id'] = HomepageSectionItem::where('section_id', $request->section_id)->get()->pluck('item_id')->toArray();

        $item = Category::where('status', 1);
        if ($request->item) {
            $keyword = $request->item;
            $item->where('name', 'like', '%' . $keyword . '%');
        }
        if ($request->category && $request->category != 'all') {
            $item->where('parent_id', $request->category);
        }
        $data['allCategories'] = $item->orderBy('name', 'asc')->paginate(25);

        return view('admin.homepage.sectionItem.getCategory')->with($data);
    }

    //get all banner by anyone field
    public function getAllbanners(Request $request){
        $data['items_id'] = HomepageSectionItem::where('section_id', $request->section_id)->get()->pluck('item_id')->toArray();

        $item = Banner::where('status', 1);
        if ($request->item) {
            $keyword = $request->item;
            $item->where('title', 'like', '%' . $keyword . '%');
        }

        $data['allBanners'] = $item->orderBy('title', 'asc')->paginate(25);

        return view('admin.homepage.sectionItem.getBanner')->with($data);
    }

    //added section single Course
    public function sectionSingleItemStore(Request $request)
    {
        $section = HomepageSection::where('id', $request->section_id)->first();
        if($section){
            $sectionItem = HomepageSectionItem::where('section_id', $request->section_id)->where('item_id', $request->item_id)->first();
            if(!$sectionItem) {
                $sectionItem = new HomepageSectionItem();
                $sectionItem->section_id = $request->section_id;
                $sectionItem->item_id = $request->item_id;
                $sectionItem->approved = 1;
                $sectionItem->status = 'active';
                $sectionItem->save();
                $output = [
                    'status' => true,
                    'msg' => 'Item added success.'
                ];
            }else{
                $output = [
                    'status' => false,
                    'msg' => 'This Item already added.'
                ];
            }
        }
        return response()->json($output);
    }

    //added section multi Course
    public function sectionMultiItemStore(Request $request){

        if($request->item_id){
            foreach ($request->item_id as $item_id => $value) {
                $sectionItem = HomepageSectionItem::where('section_id', $request->section_id)->where('item_id', $item_id)->first();
                if(!$sectionItem){
                    $sectionItem = new HomepageSectionItem();
                    $sectionItem->section_id = $request->section_id;
                    $sectionItem->item_id = $item_id;
                    $sectionItem->approved = 1;
                    $sectionItem->status = 'active';
                    $sectionItem->save();
                }else{
                    Toastr::error('Item already added.');
                }
            }
        }else{
            Toastr::error('Item added failed, Please select any item');
        }
        return back();
    }

    public function itemRemove($id)
    {
        $section = HomepageSectionItem::find($id);
        if($section){
            $section->delete();
            $output = [
                'status' => true,
                'msg' => 'Section item remove successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Section item cannot remove.'
            ];
        }
        return response()->json($output);
    }

}

<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait CreateSlug {

    public function createSlug($table, $slug, $field='')
    {
        $field = ($field) ? $field : 'slug';

        $slug = strTolower(preg_replace('/[\s]+/', '-', trim($slug)));
        $slug = (preg_replace("/[?.,'&\/]+/", "", trim($slug)));
        $slug = (preg_replace("/[--]+/", "-", trim($slug)));
        $slug = (preg_replace("/[---]+/", "-", trim($slug)));

        $check_slug = DB::table($table)->select($field)->where($field, 'like', $slug.'%')->get();

        if (count($check_slug)>0){
            //find slug until find not used.
            for ($i = 1; $i <= count($check_slug); $i++) {
                $newSlug = $slug.'-'.$i;
                if (!$check_slug->contains($field, $newSlug)) {
                    return $newSlug;
                }
            }
        }else{ return $slug; }
    }

    public function uniqueOrderId($table, $field)
    {
        $user_id = Auth::id();
        $numberLen = strlen($user_id);
        $numberLen = 7 - $numberLen;
        $order_id = 'E' . $user_id . strtoupper(substr(str_shuffle("0123456789"), -$numberLen));

        $check_path = DB::table($table)->select($field)->where($field, 'like', $order_id.'%')->get();
        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= count($check_path); $i++) {
                $new_order_id = 'E' . $user_id . strtoupper(substr(str_shuffle("0123456789"), -$numberLen));
                if (!$check_path->contains($field, $new_order_id)) {
                    return $new_order_id;
                }
            }
        }else{ return $order_id; }
    }

    public function uniqueImagePath($table, $field, $imagePath)
    {

        $check_path = DB::table($table)->select($field)->where($field, 'like', '%'.$imagePath)->get();

        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= count($check_path); $i++) {
                $newPath = $i.'-'.$imagePath;
                if (!$check_path->contains($field, $newPath)) {
                    return $newPath;
                }
            }
        }else{ return $imagePath; }
    }
}

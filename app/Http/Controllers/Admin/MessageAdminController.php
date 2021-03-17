<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageAdminController extends Controller
{
    public function index(){
        $user_id = Auth::guard()->id();
        $data['users'] = User::where('id', '!=', $user_id)->get();
        return view('admin.message.message')->with($data);
    }
}

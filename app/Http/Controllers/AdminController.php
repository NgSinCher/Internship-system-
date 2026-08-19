<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createUser()
    {
        return view('admin.create_user'); // 告诉系统去展示这个画面
    }
    public function storeUser(Request $request)
   {
       // 1. 验证用户填入的数据
       $request->validate([
           'name' => 'required|string|max:255',
           'user_id' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:8',
           'role' => 'required|string'
       ]);

       // 2. 将数据存入数据库
       \App\Models\User::create([
           'name' => $request->name,
           'student_staff_id' => $request->user_id,
           'email' => $request->email,
           'password' => bcrypt($request->password), // 密码必须加密
           'role' => $request->role,
       ]);

       // 3. 存完之后，跳回当前页面并给个成功提示
       return back()->with('success', 'User created successfully!');
   }
}

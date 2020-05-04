<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginAdminForm()
    {
    	return view('admin.pages.login');
    }

    public function loginAdmin(Request $request)
    {
    	$this->validate($request,
    		[
    			'username' => 'required|max:10|min:3',
    			'password' => 'required|max:10|min:5'
    		],
    		[
    			'username.required' => '* Cần điền tên đăng nhập',
    			'username.max' => '* Tên đăng nhập phải ít hơn 10 ký tự',
    			'username.min' => '* Tên đăng nhập phải nhiều hơn 3 ký tự',
    			'password.required' => '* Cần điền mật khẩu'
    		]
    	);
    	$data = [
			'name' => $request->username,
			'password' => $request->password,
		];

    	if (auth()->attempt($data)) {
			return redirect()->route('admin.category.list');
		} else {
			return back()->with('error', 'Đăng nhập sai');
		}
    }

    public function logout()
    {
    	auth()->logout();

    	return redirect()->route('admin.login_admin');
    }
}

<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login()
    {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.pages.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'logout-success');
    }

    public function authenticate(Request $request)
    {
        $rules = [
            'email' => [
                'required',
                'email'
            ],
            'password' => 'required',
        ];

        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = \App\Models\Admin::find(Auth::guard('admin')->user()->id);
            if($admin->is_active != 1) {
                Auth::guard('admin')->logout();
                return redirect(route('admin.login'))
                    ->withInput($credentials)
                    ->with('error', 'admin-account-inactive');
            }
            return redirect()->route('admin.dashboard')->with('success', 'login-success');
        } else {
            return redirect()->back()
                ->withInput($credentials)
                ->withErrors($validator)
                ->with('error', 'admin-account-not-found');
        }
    }
}

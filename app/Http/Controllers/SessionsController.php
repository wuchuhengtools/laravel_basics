<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    /**
     *
     *
     *
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     *  登录视图
     *
     * @return void
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 登录操作
     *
     * @return void
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                // 优先返回上次没登录无权访问的页面，没有就返回个人主页
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('error', '验证邮件已发送到你的注册邮箱上，请注意查收。');
                return redirect('/');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    /*
     * 退出操作
     *
     * @return obj  重定向
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}

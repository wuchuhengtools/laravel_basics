<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return View('users/create');
    }

    /**
     *  display one user
     *
     * @http get
     * @return obj  pages
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * add user action
     *
     * @http post
     * @return volid
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 用户编辑视图
     *
     * @http   get
     * @return ojb 调用视图
     */
     public function edit(User $user)
     {
         return view('users.edit', compact('user'));
     }

     /**
      * 编辑操作
      *
      * @http patch
      */
      public function update(Request $request)
      {
          $this->validate($request, [
              'name' => 'required|max:50',
              'password' => 'nullable|confirmed|min:6'
          ]);
          $User = User::find($request->user);
          $User->name = $request->name;
          if ($request->getPassword) $User->password = $request->password;
          $User->update();
          session()->flash('success', '更新成功!');
          return redirect()->route('users.show', $User->id);
      }
}

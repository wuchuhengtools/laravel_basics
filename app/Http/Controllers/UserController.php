<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * 权限过滤
     *
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     *  用户列表视图
     *
     * @return obj html
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('users.index', compact('users'));
    }

    /**
     * 登录视图
     *
     * @return obj  视图
     */
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
         $this->authorize('update', $user);
         return view('users.edit', compact('user'));
     }

     /**
      * 编辑操作
      *
      * @http patch
      */
      public function update(User $user, Request $request)
      {
          $this->authorize('update', $user);
          $this->validate($request, [
              'name' => 'required|max:50',
              'password' => 'nullable|confirmed|min:6'
          ]);

          $data = [];
          $data['name'] = $request->name;
          if ($request->password) {
              $data['password'] = bcrypt($request->password);
          }
          $user->update($data);

          session()->flash('success', '个人资料更新成功！');

          return redirect()->route('users.show', $user);
      }

      /**
       *  删除用户
       * @return obj 重定向返回
       */
      public function destroy(User $user)
      {
            $user->delete();
            session()->flash('info', '成功删除用户');
            return back();
      }

}

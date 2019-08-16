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
        return;
    }
}

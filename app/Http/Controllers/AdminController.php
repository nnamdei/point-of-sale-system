<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function store(Request $request){

        $this->validate($request,[
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'email' => ['required','email', 'unique:admins'],
            'password' => 'required|string|min:6|confirmed',

        ]);

        $admin = Admin::create([
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'email' => $request->email,
            'level' => 'admin',
        ]);

        $user = User::create([
            'email' => $request->email,
            'admin_id' => $admin->id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('index')->with('success', 'You can now login');
    }
}

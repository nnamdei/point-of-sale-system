<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Staff;
use App\Admin;
use App\Matto\FileUpload;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __construct(){
        // $this->middleware('check-shop')->except(['noShop']);
    }

    public function index(){
        return view('index');
    }

    public function deskClosed(){
        if(!Auth::user()->deskClosed()){
            return redirect()->route('desk');
        }
        return view('pages.desk-closed');
    }

    public function noShop(){
        if(Auth::user()->hasShop()){
            return redirect()->route('index');
        }
        return view('pages.no-shop');
    }

    public function update(){
        $users = User::all();
       if(DB::unprepared(file_get_contents('db.sql'))){
            foreach($users as $user){
                // if($user->position == 1){
                //     Admin::create([
                //         'firstname' => $user->firstname == '' ? 'missing' : $user->firstname,
                //         'lastname' => $user->lastname == '' ? 'missing' : $user->lastname,
                //         'level' => 1
                //     ]);
                // }
                // else{
                //     Staff::create([
                //         'firstname' => $user->firstname == '' ? 'missing' : $user->firstname,
                //         'lastname' => $user->lastname == '' ? 'missing' : $user->lastname,
                //         'role' => 'staff'
                //     ]);
                // }
            }
       }

    }
}

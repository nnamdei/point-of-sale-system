<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DNS1D;
use DNS2D;
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
    public function generateSerial(){
        $serial = '1-6'.rand(100,999).'-'.rand(1000,9999).'-'.rand(100,999).'-'.rand(10,99);
        return $serial;
    }

    public function barcode(){
        $serial = $this->generateSerial();
         $barcode = DNS1D::getBarcodePNG('1', "C39+",3,33);
         return view('barcode')->with('barcode', $barcode)->with('serial',$serial);
    }
    public function index(){
        if(Auth::check()){
            if(!Auth::user()->hasShop()){
                return view('pages.no-shop');
            }
            return view('shop.show')->with('shop',Auth::user()->shop);
        }
        else{
            if(Admin::where('level','!=','superadmin')->count() > 0){//if there is admin asides the default superadmin
                return view('user.login');
            }
            else{
                return view('welcome'); //welcome page to set admin account up
            }
        }
    }

    public function deskClosed(){
        if(!Auth::user()->deskClosed()){
            return redirect()->route('index');
        }
        return view('pages.desk-closed');
    }

    public function noShop(){
        if(Auth::user()->hasShop()){
            return redirect()->route('index');
        }
        return view('pages.no-shop');
    }

   /* public function update(){
        $users = User::all();
       if(DB::unprepared(file_get_contents('db.sql'))){
            foreach($users as $user){
                if($user->position == 1){
                    Admin::create([
                        'firstname' => $user->firstname == '' ? 'missing' : $user->firstname,
                        'lastname' => $user->lastname == '' ? 'missing' : $user->lastname,
                        'level' => 1
                    ]);
                }
                else{
                    Staff::create([
                        'firstname' => $user->firstname == '' ? 'missing' : $user->firstname,
                        'lastname' => $user->lastname == '' ? 'missing' : $user->lastname,
                        'role' => 'staff'
                    ]);
                }
            }
       }

    }*/
}

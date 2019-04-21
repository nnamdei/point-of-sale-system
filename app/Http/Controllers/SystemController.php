<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Artisan;
use App\User;
use App\Admin;
use App\Software;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct(){
        $this->middleware('superadmin')->except(['status']);
    }
    private function verifyPassword($password){
        $superadmin = Admin::where('level', 'superadmin')->first();
        return Hash::check($password, $superadmin->user->password) ? true : false;
    }
    
    public function status(){
        $software = Software::first();
        return view('system.status')->with('status', $software->status);
    }

    public function setup(){
        $software = Software::first();
        return view('system.index')->with('system',$software);
    }

    public function update(Request $request){
        $this->validate($request,[
            'package' => ['required'],
            'status' => ['required'],
            'password' => ['required']
        ]);
        if($this->verifyPassword($request->password)){
            $software = Software::first();
            $software->package = $request->package;
            $software->status = $request->status;
            // $software->cache_age = $request->cache_age;
            // if($request->has('clear_cache')){
            //     $software->cache_expires = 0;
            // }
            $software->save();
            return redirect()->back()->with('success', 'SUCCESS!');
        }
        return redirect()->back()->with('error', 'FAILED!');
    }
    public function clearSystemCache(){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return redirect()->back()->with('info','System cache cleared!');
    }

    public function runArtisan(Request $request){
        $this->validate($request,[
            'command' => 'required',
        ]);

        try {
            
            Artisan::call($request->command, [$request->parameter => $request->value]);
        } catch (\Exception $e) {
            return "<pre>$request->command</pre><p style='color: red'>".$e->getMessage()."</p>";
        }
        return "<pre>$request->command</pre><p style='color: green'>Success</p>";
        return redirect()->back()->with('error', 'Failed!');
    }
}

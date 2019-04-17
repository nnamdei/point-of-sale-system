<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Shop;
use App\Matto\FileUpload;
use App\Inventory\Transaction;

class UserController extends Controller
{


    public function switchShop($id){

        $user = Auth::user();
        $shop = Shop::findorfail($id);
        $user->shop_id = $shop->id;
        $user->save();

        return redirect()->back()->with('success','checked in to '.$shop->name);
    }

    public function editPassword(){
        return view('user.edit-password')->with('user',Auth::user());
    }

    public function updatePassword(Request $request){
        $user = Auth::user();

        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('index')->with('success','Password changed');
        }
        else{
            return redirect()->back()->with('error','Old password not correct');
        }
    }

}

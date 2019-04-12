<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Shop;
use App\Matto\FileUpload;
use App\Inventory\Transaction;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('manager')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'shop' => 'required',
            'role' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
      
        $user = new User();
        $user->email = $request->email;
        $user->shop_id = $request->shop;
        $user->role = $request->position;
        $user->password =  bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', "New user authorized");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findorfail($id);
        return redirect()->route('staff.show',[$user->profile->id]);
    }

    public function switchShop($id){

        $user = Auth::user();
        $shop = Shop::findorfail($id);
        $user->shop_id = $shop->id;
        $user->save();

        return redirect()->back()->with('success','switched to '.$shop->name);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->delete();
        return redirect()->back()->with('success', "$user->firstname $user->lastname deleted");
    }
}

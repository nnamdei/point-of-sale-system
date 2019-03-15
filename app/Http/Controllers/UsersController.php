<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Matto\FileUpload;
use App\Inventory\Transaction;

class UsersController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
      
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname =  $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->password =  bcrypt($request->password);
          
        if($request->hasFile('avatar')){
            $upload = new FileUpload(
                        $request,
                        $name = 'avatar',$title =$request->firstname.' '.$request->lastname,
                        $path = 'public/images/users'
                    );
            $user->avatar = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }
        $user->save();

        

        return redirect()->back()->with('success', "New user $request->firstname $request->lastname added");

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

        $t = new Transaction();
        $transactions = $t->userTransactions($user->id);

        return view('users.show')->with('user',$user)
                                ->with('period', $transactions['period'])
                                ->with('sales',$transactions['sales'])
                                ->with('activities', $transactions['activities']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);
        return view('users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findorfail($id);

        $this->validate($request, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
      
        $user->firstname = $request->firstname;
        $user->lastname =  $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
          
        if($request->hasFile('avatar')){
            $upload = new FileUpload(
                        $request,
                        $name = 'avatar',$title =$request->firstname.' '.$request->lastname,
                        $path = 'public/images/users'
                    );
            $user->avatar = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }
        $user->save();
        return redirect()->route('users.show',['id'=>$user->id])->with('success', "$request->firstname $request->lastname updated");
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
        return redirect()->route('users.index')->with('success', "$user->firstname $user->lastname deleted");
    }
}

<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use App\Shop;
use App\Staff;
use Illuminate\Http\Request;
use App\Inventory\Transaction;
use App\Events\StaffAuthorization;



class StaffController extends Controller
{

    private function generatePassword(){
        $hash = Hash::make(time());
        return substr($hash, 10,7);
    }

    private function isAuthorizable($email){
        $e = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($e, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    private function emailAlreadyAuthorized($email){
        return User::withTrashed()->where('email',$email)->get()->count() > 0 ? true : false;
    }


    private function authenticate($staff,$position){
        $password = $this->generatePassword();
        $auth = $staff->user();

        if($auth != null){ //if staff already authorized, just change the password
           $auth->password = Hash::make($password);
           $auth->deleted_at = null;
           $auth->save();
           event(new StaffAuthorization($staff,$position,$password));
           return true;
        }
        elseif(!$this->emailAlreadyAuthorized($staff->email)){ //check if the email is not authorized for another staff
            $auth = User::create([
                'shop_id' => $staff->shop->id,
                'staff_id' =>$staff->id,
                'email' => $staff->email,
                'password' => Hash::make($password)
            ]);
            event(new StaffAuthorization($staff,$position,$password));
            return true;
        }

        return false;
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.index')->with('staffs',Auth::user()->shop->staff);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.create');
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
        ]);

        $staff = new Staff;
        $staff->shop_id = Auth::user()->shop->id;
        $staff->firstname = $request->firstname;
        $staff->lastname = $request->lastname;
        $staff->position = 'Regular staff';
        $staff->email = $request->email;

        if($request->hasFile('avatar')){
            $upload = new FileUpload(
                        $request,
                        $name = 'avatar',$title =$request->firstname.' '.$request->lastname,
                        $path = 'public/images/users'
                    );
            $staff->avatar = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }

        $staff->save();

        return redirect()->route('staff.show',[$staff->id])->with('success','New staff added to '.Auth::user()->shop->name);

    }    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $staff = Staff::findorfail($id);

        $t = new Transaction();
        if($staff->isAttendant() || $staff->isManager()){
            $transactions = $t->attendantTransactions($staff->user()->id);
            return view('staff.show')->with('staff',$staff)
                                        ->with('period', $transactions['period'])
                                        ->with('sales',$transactions['sales'])
                                        ->with('activities', $transactions['activities'])
                                        ->with('sales_chart',$transactions['sales_chart'])
                                        ->with('service_records',$transactions['service_records'])
                                        ->with('services_chart',$transactions['services_chart']);
        }else{
            $transactions = $t->staffServices($staff->id);
            return view('staff.show')->with('staff',$staff)
                                        ->with('period', $transactions['period'])
                                        ->with('service_records',$transactions['service_records'])
                                        ->with('services_chart',$transactions['services_chart']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('staff.edit')->with('staff', Staff::findorfail($id));
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
        $this->validate($request, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $staff = Staff::findorfail($id);
        $staff->firstname = $request->firstname;
        $staff->lastname = $request->lastname;
        $staff->email = $request->email;
        
        if($request->hasFile('avatar')){
            $upload = new FileUpload(
                        $request,
                        $name = 'avatar',$title =$request->firstname.' '.$request->lastname,
                        $path = 'public/images/users'
                    );
            $staff->avatar = isset($upload->slugs[0]) ? $upload->slugs[0] : null;
        }
        $staff->save();

        if($staff->user() != null){ //update the authentication email also
            $staff->user()->email = $request->email;
            $staff->user()->save();
        }
        
        return redirect()->route('staff.show',[$staff->id])->with('success','staff updated');


    }

    public function changePosition(Request $request, $id){
        $this->validate($request,[
            'new_position' => 'required'
        ]);
        $staff = Staff::findorfail($id);
        $auth = $staff->user();

        if($request->new_position == 'attendant' || $request->new_position == 'manager'){
            if($this->isAuthorizable($staff->email)){
                if($this->authenticate($staff,$request->new_position)){
                    $staff->position = $request->new_position;
                    $staff->save();
                    return redirect()->back()->with('success',$staff->fullname().' made '.$request->new_position.' in '.$staff->shop->name.' Login credentials have been sent to '.$staff->email);
                }
                else{
                    return redirect()->back()->with('error',$staff->fullname().' authentication failed');
                }
            }
            else{
                return redirect()->back()->with('error', $staff->fullname().' does not have a valid email address. A valid email address is needed for '.$request->new_position.' position');
            }
        }
        else{
            if($auth != null){ //if the staff was authorized before
                $auth->delete(); //delete staff authentication
            }
            $staff->position = $request->new_position;
            $staff->save();
            return redirect()->back()->with('success',$staff->fullname().' made '.$request->new_position.' in '.$staff->shop->name);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::findorfail($id);
        if($staff->user() != null){
            $staff->user()->delete(); //trash authentication
        }
        $staff->delete();

        return redirect()->route('staff.index')->with('success',$staff->fullname().' removed');
    }
}

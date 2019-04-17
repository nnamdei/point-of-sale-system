<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Shop;
use App\Software;
use App\ShopSetting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(){
        $this->middleware('admin')->except([
            'show'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop.index')->with('shops', Shop::all());
    }

    public function lowStocks($id){
        $shop = Shop::findorfail($id);
        if($shop->setting->lowStockWarningActivated()){
            return view('shop.low-stocks')->with('shop',$shop);
        }
        return redirect()->back()->with('info', 'Low stock warning is not enabled');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $software = Software::first();
        if(Shop::all()->count() >= 1 && !$software->isPremium()){
            return redirect()->back()->with('info', 'Multiple shop available only in premium');
        }
        return view('shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'unique:shops'],
            'shop_address' => ['required'],
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'address' => $request->shop_address,
            'phone' => $request->shop_phone,
            'email' => $request->shop_email_address,
            'about' => $request->about_shop
        ]);

        Auth::user()->shop_id = $shop->id; //checkin to the newly created shop
        Auth::user()->save();

        $setting = ShopSetting::create([
            'shop_id' => $shop->id
        ]);

        return redirect()->route('shop.show',[$shop->id])->with('success', 'New shop '.$shop->name.' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('shop.show')->with('shop',Shop::findorfail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::findorfail($id);
        if(!$shop->checkedIn()){
            return redirect()->route('index')->with('info', 'You are currently not checked in to '.$shop->name);
        }
 
        return view('shop.edit')->with('shop',$shop);
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
        $shop = Shop::findorfail($id);
        if(!$shop->checkedIn()){
            return redirect()->route('index')->with('info', 'You are currently not checked in to '.$shop->name);
        }

        $this->validate($request,[
            'name' => ['required'],
            'shop_address' => ['required'],
        ]);


        if(Shop::where([['name',$request->name],['id','!=',$shop->id]])->count() > 0){
            return redirect()->back()->with('error', 'There is already another shop with that name');
        }
        $shop->name = $request->name;
        $shop->address = $request->shop_address;
        $shop->about = $request->about;
        $shop->phone = $request->shop_phone;
        $shop->email = $request->shop_email_address;
        $shop->save();

        if($request->theme_color != null){
            $shop->setting->theme = $request->theme_color;
            $shop->setting->save();
        }
        return redirect()->route('shop.show',[$shop->id])->with('success', $shop->name.' updated');
    }

    public function updateProductSetting(Request $request, $id){
        $shop = Shop::findorfail($id);
        if(!$shop->checkedIn()){
            return redirect()->route('index')->with('info', 'You are currently not checked in to '.$shop->name);
        }

        $setting = $shop->setting;

        $setting->product_activation = $request->product_activation == null ? 0 : 1;
        $setting->low_stock_warning_activation = $request->low_stock_warning_activation == null ? 0 : 1;
        $setting->low_stock = $request->low_stock == null ? 5 : $request->low_stock;
        $setting->save();

        return redirect()->route('shop.show',[$shop->id])->with('success','settings saved');
    }

    public function updateServiceSetting(Request $request, $id){
        $shop = Shop::findorfail($id);
        $shop = Shop::findorfail($id);
        if(!$shop->checkedIn()){
            return redirect()->route('index')->with('info', 'You are currently not checked in to '.$shop->name);
        }

        $setting = $shop->setting;

        $setting->service_activation = $request->service_activation == null ? 0 : 1;
        $setting->save();

        return redirect()->route('shop.show',[$shop->id])->with('success','setting saved');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $shop = Shop::findorfail($id);
        if(!$shop->checkedIn()){
            return redirect()->route('index')->with('info', 'You are currently not checked in to '.$shop->name);
        }

        $this->validate($request, [
            'password' => ['required']
        ]);
        if(Hash::check($request->password, Auth::user()->password)){
            $shop->forceDelete();
            return redirect()->route('shop.index')->with('success', $shop->name.' deleted');
        }
        else{
            return redirect()->back()->with('error', 'could not delete shop '.$shop->name.' password incorrect');
        }
    }
}

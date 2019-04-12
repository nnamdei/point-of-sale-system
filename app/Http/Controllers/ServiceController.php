<?php

namespace App\Http\Controllers;

use Auth;
use App\Shop;
use App\Service;
use App\ServiceRecord;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function record(Request $request, $id){
        $this->validate($request,[
            'staff' => ['required'],
            'ammount_paid' => ['required','numeric'] 
        ]);

        $service = Service::findorfail($id);
        $record = ServiceRecord::create([
            'shop_id' => Auth::user()->shop->id,
            'user_id' => Auth::id(),
            'staff_id' => $request->staff,
            'service_id' => $service->id,
            'paid' => $request->ammount_paid,
            'note' => $request->note,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone
        ]);

        return redirect()->route('shop.show',[$service->shop->id])->with('success', 'Service recorded');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.create');
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
            'shop' => 'required',
			'name' => 'required|unique:services',
			'price' => 'required|numeric',
        ]);

        $shop = Shop::findorfail($request->shop);

        $service = new Service;
        $service->user_id = Auth::id();
        $service->shop_id = $shop->id;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        return redirect()->route('shop.show',[$shop->id])->with('success','New service '.$service->name.' added to '.$shop->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findorfail($id);
        if(!$service->inMyShop()){
            return redirect()->route('index')->with('info', 'You are not checked in to the shop the service is in');
        }
        return view('service.show')->with('service', $service);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findorfail($id);
        if(!$service->inMyShop()){
            return redirect()->route('index')->with('info', 'You are not checked in to the shop the service is in');
        }
        return view('service.edit')->with('servioe', $service);
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
        $this->validate($request,[ 
            'shop' => 'required',
			'name' => 'required',
			'price' => 'required|numeric',
        ]);

        $service = Service::findorfail($id);
        if(!$service->inMyShop()){
            return redirect()->route('index')->with('info', 'You are not checked in to the shop the service is in');
        }
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        return redirect()->route('shop.show',[$shop->id])->with('success','service '.$service->name.' in '.$shop->name.' updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findorfail($id);
        if(!$service->inMyShop()){
            return redirect()->route('index')->with('info', 'You are not checked in to the shop the service is in');
        }

        $service->delete();
        return redirect()->route('shop.show',[$shop->id])->with('success','service '.$service->name.' deleted from '.$shop->name);
    }
}

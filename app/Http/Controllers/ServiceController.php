<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Hash;
use App\Shop;
use App\Service;
use App\ServiceRecord;
use App\Inventory\Transaction;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(){
        $this->middleware('service-activated');
        $this->middleware('manager')->except(['show','index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Auth::user()->shop->services;
        return view('service.index')->with('services', $services);
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
        if(Auth::user()->isAttendant()){
            return view('desk.service')->with('service', $service);
        }
        $t = new Transaction;
        $records = $t->serviceRecords($service->id);
        return view('service.show')->with('service', $service)
                                    ->with('period', $records['period'])
                                    ->with('service_records',$records['service_records']);
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
        return view('service.edit')->with('service', $service);
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

        return redirect()->route('shop.show',[$service->shop->id,'tab' => 'services'])->with('success','service '.$service->name.' in '.$service->shop->name.' updated');
        
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
        return redirect()->route('shop.show',[$service->shop->id])->with('success','service '.$service->name.' deleted from '.$service->shop->name);
    }
}

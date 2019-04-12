<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop.index')->with('shops', Shop::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'about' => $request->about_shop
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
        return view('shop.edit')->with('shop',Shop::findorfail($id));
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
            'name' => ['required', 'unique:shops'],
            'address' => ['required'],
        ]);

        $shop = Shop::findorfail($id);
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->about = $request->about;
        $shop->save();

        return redirect()->route('shop.show',[$shop->id])->with('success', $shop->name.' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::findorfail($id);
        $shop->delete();

        return redirect()->route('shop.index')->with('success', $shop->name.' deleted');
    }
}

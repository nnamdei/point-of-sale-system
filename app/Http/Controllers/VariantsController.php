<?php

namespace App\Http\Controllers;

use Validator;
use App\Variant;
use App\Product;

use App\Inventory\StockManager;
use Illuminate\Http\Request;

class VariantsController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $variant = Variant::find($id);
        if($variant == null){
            return redirect()->route('products.index')->with('info', 'Variant does not exist');
        }
        return view('variants.edit')->with('variant',$variant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variant = Variant::find($id);
        if($variant == null){
            return redirect()->route('products.index')->with('info', 'Variant does not exist');
        }
        return view('variants.edit')->with('variant',$variant);
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
        $variant = Variant::find($id);
        if($variant == null){
            return redirect()->route('products.index')->with('info', 'Variant does not exist');
        }

        $rules = array();
        $prevValuesArray = $variant->values();
        $newValuesArray = array();
        $newStocksArray = $variant->stocks();
        $newSalesArray = $variant->sales();

        foreach($prevValuesArray as $value){
            $rules[$value] = 'required|string';//validating each of the previous field, this way, the new value array will still be consistent
            if(!is_numeric($request->$value)){
                $_v = str_replace('-','_',str_slug($request->$value));
                array_push($newValuesArray,$_v); //push the new value name
            }
            else{//push the formal value
                array_push($newValuesArray,$value);
            }
           
        }
        $this->validate($request, $rules, ['required' => 'one or more values is/are invalid','string' => 'values can only contain alphabet or alphanumeric']);
        $feedback = "variant <strong>$variant->variable</strong> updated.";
        $newStock = 0;

        for($i=0; $i<count($request->new_values); $i++){//check for new values;
            if($request->new_values[$i] !== null && !is_numeric($request->new_values[$i])){
                $_nv = str_replace('-','_',str_slug($request->new_values[$i]));
                array_push($newValuesArray,$_nv);
                $newValueStock = $request->new_stocks[$i] !== null && is_numeric($request->new_stocks[$i]) ? $request->new_stocks[$i] : 0;
                array_push($newStocksArray,$newValueStock);
                array_push($newSalesArray, 0);
                $newStock +=  $newValueStock;
            }
            
        }
        $feedback .= $newStock > 0 ? " <strong>$newStock</strong> more stock added to ".$variant->product->name."" : '';

        $variant->variable = $request->variable;
        $variant->values = join('|', $newValuesArray);
        $variant->stocks = join('|', $newStocksArray);
        $variant->sales = join('|', $newSalesArray);
        $variant->save();

        $manager = new StockManager($variant->product->id);
        $manager->addStock($newStock);

        return redirect()->back()->with('success',$feedback);
    }
/**
 * 
 */
    public function removeSingleValue(Request $request, $variant_id, $value_index){
        $variant = Variant::find($variant_id);
        if($variant == null){
            return redirect()->route('products.index')->with('info', 'Variant does not exist');
        }
        $product = Product::find($variant->product->id);
        //decouple the values,stocks, and sales
        $values = $variant->values();
        $stocks = $variant->stocks();
        $sales = $variant->sales();
        $stock = 0;
        $sale = 0;
        for($i=0; $i<count( $values); $i++){
            if($i ==  $value_index){
                $value = $values[$i];
                $stock = $stocks[$i];
                $sale = $stocks[$i];
               //remove the corresponding index
              array_splice($values,$i,1);
              array_splice($stocks,$i,1);
              array_splice($sales,$i,1);
            }
        }
        //if there are still other values
        if(count($values) > 0){
            //couple back
            $variant->values = join('|',$values);
            $variant->stocks = join('|',$stocks);
            $variant->sales = join('|',$sales);
            $variant->save();
        }
        else{
            $variant->delete();
        }

        $manager = new StockManager($variant->product->id);
        $manager->removeStock($stock);
        $manager->removeSale($sale);


        return redirect()->back()->with('success',"<strong>$value</strong> of the variable <strong>$variant->variable </strong> for <strong>".$variant->product->name."</strong> removed. Product stock and sales updated.");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variant = Variant::find($id);
        if($variant == null){
            return redirect()->route('products.index')->with('info', 'Variant does not exist');
        }
        $variantStock = $variant->totalStock();
        $variantSale =  $variant->totalSale();
        $variant->delete();

        $manager = new StockManager($variant->product->id);
        $manager->removeStock($variantStock);
        $manager->removeSale($variantSale);

        return redirect()->route('products.show',['id'=>$variant->product->id])->with('success',"<strong>$variant->variable</strong> deleted. $variantStock and $variantSale removed from ".$variant->product->name." stock and sale respectively");
    }
}

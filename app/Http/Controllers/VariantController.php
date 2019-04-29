<?php

namespace App\Http\Controllers;

use Validator;
use App\Variant;
use App\Product;
use App\Traits\BarcodeTrait;
use App\Inventory\StockManager;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    use BarcodeTrait;
    
    public function __construct(){
        $this->middleware('manager');
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
        return view('variant.edit')->with('variant',$variant);
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
        return view('variant.edit')->with('variant',$variant);
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
        $newValuesArray = $variant->values();
        $newStocksArray = $variant->stocks();
        $newSalesArray = $variant->sales();

        $feedback = "variant <strong>$variant->variable</strong> updated.";
        if(count($request->new_values) > 0){ //if there are new values
            $newStock = 0;
            for($i=0; $i<count($request->new_values); $i++){//check for new values;
                if($request->new_values[$i] !== null && !is_numeric($request->new_values[$i])){
                    $_nv = str_replace('-','_',str_slug($request->new_values[$i]));
                    $newValueStock = $request->new_stocks[$i] !== null && is_numeric($request->new_stocks[$i]) ? $request->new_stocks[$i] : 0;
                    if(!in_array($_nv,$newValuesArray)){ //if the value is not existing before
                        array_push($newValuesArray,$_nv);
                        array_push($newStocksArray,$newValueStock);
                        array_push($newSalesArray, 0);
                        $newStock +=  $newValueStock;
                    }
                }
                
            }
            $feedback .= $newStock > 0 ? " <strong>$newStock</strong> more stock added to ".$variant->product->name."" : '';
        }

        $variant->variable = $request->variable;
        $variant->values = join('|', $newValuesArray);
        $variant->stocks = join('|', $newStocksArray);
        $variant->sales = join('|', $newSalesArray);
        $variant->save();

        if($variant->product->barcodes->count() > 0){ //if the product has barcodes already, regenerate it to include the new variant value
            $this->attachVariantBarcode($variant);
        }

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
              $this->deleteVariantValueBarcode($variant,$value); //delete the corresponding barcode
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

        $this->deleteVariantBarcodes($variant);

        $manager = new StockManager($variant->product->id);
        $manager->removeStock($variantStock);
        $manager->removeSale($variantSale);

        return redirect()->route('products.show',['id'=>$variant->product->id])->with('success',"<strong>$variant->variable</strong> deleted. $variantStock and $variantSale removed from ".$variant->product->name." stock and sale respectively");
    }
}

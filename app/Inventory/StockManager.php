<?php 
namespace App\Inventory;

use Auth;
use App\Sale;
use App\Action;
use App\Product;
use App\Variant;

class StockManager{
    public $product_id;

    public function __construct($id){
        $this->product_id = $id;
    } 
    //record an action
        public function action($user,$product,$operation,$price,$qty){
            Action::create([
                'shop_id' => Auth::user()->shop->id,
                'user_id' => $user,
                'product_id' => $product,
                'operation' => $operation,
                'price' => $price,
                'quantity' => $qty
            ]);
        }

        public function sale($user,$product,$cart,$price,$qty){
            Sale::create([
                'shop_id' => Auth::user()->shop->id, 
                'user_id' => $user,
                'product_id' => $product,
                'cart_id' => $cart,
                'price' => $price,
                'quantity' => $qty
            ]);
        }
    


    public function addStock($qty){
        $product = Product::find($this->product_id);
        $product->stock = $product->stock + $qty;
        $product->save();

        $this->action(Auth::id(),$product->id,1,$product->selling_price,$qty);

        return ['success' => ["$qty stocks added to $product->name"]];
    }

    public function addSale($cart_id,$item){
        $product = Product::find($this->product_id);
        if($item->qty > $product->remaining()){
            return ['error' => ["$item->qty sales of $product->name not feasible, only <strong>".$product->remaining()."</strong> remaining"]];
        }
         else{
            $product->sale = $product->sale + $item->qty;
            $product->save();
            $this->sale(Auth::id(),$product->id,$cart_id,$product->selling_price,$item->qty);
            return ['success' => ["$item->qty sales added to $product->name"]];
         }
    }
    
    public function removeSale($qty){
        $product = Product::find($this->product_id);
        $product->sale = $product->sale - $qty;
        $product->save();

        $this->action(Auth::id(),$product->id,3,$product->selling_price,$qty);

        return ['success' => ["$qty sales removed from $product->name"]];
    }

    public function removeStock($qty){
        $product = Product::find($this->product_id);
        $product->stock = $product->stock - $qty;
        $product->save();

        $this->action(Auth::id(),$product->id,2,$product->selling_price,$qty);

        return ['success' => ["$qty stocks removed from $product->name"]];
    }
    



    public function updateVariableStocks($request){

        $response = array(
                        'error' => array(),
                        'success' => array(),
                        'warning' => array(),
                        'info' => array()
                    );
            $totalNewStock = 0;
            $variant = Variant::find($request->v_id);
            $product = Product::find($variant->product->id);            
            $values = $variant->values();
            $prevStocksArray = $variant->stocks();
            $newStocksArray = array();

            for($i = 0; $i<count($values); $i++){
                $index = $variant->variable.'_'.$values[$i];
                $newStock = $request->$index == null ? 0 : $request->$index;
                $totalStock = $prevStocksArray[$i] + $newStock;
                array_push($newStocksArray,  $totalStock);
                $totalNewStock +=  $newStock;
                if($newStock > 0){
                    $response['success'][] = "$newStock $variant->variable $values[$i] added to $product->name";
                }
            }
            //format and save the variable stocks
            if(!empty($newStocksArray)){
                    $variant->stocks = join('|',$newStocksArray);
                    $variant->save();
                    $this->addStock($totalNewStock);
            }
        return $response;
    }

    
    // update the sales from an item in the cart
    public function updateVariableSales($cart_id,$item, $remove = false){
        $response = array(
                        'error' => array(),
                        'success' => array(),
                        'warning' => array(),
                        'info' => array()
                    );

        $product = Product::find($this->product_id); 
        if($product->variants->count() > 0){
            foreach($item->options as $variable){
                foreach($product->variants as $variant){
                    if(isset($item->options[$variant->variable])){
                        $values = $variant->values();
                        $sales = $variant->sales();
                        $remainings = $variant->remainings();
                     
                        $newSales = array();
                        for($i = 0; $i<count($values); $i++){
                            $qty = isset($variable[$values[$i]]) ? $variable[$values[$i]] : null;
                            if($qty !== null){ 
                                if(!$remove){ //if adding, not removing
                                    if($remainings[$i] - $qty < 0){
                                        $response['error'][] = "Sale of ".$values[$i]." of ".$product->name." not feasible, only $remainings[$i] remains";
                                        array_push($newSales,$sales[$i]);
                                    }else{
                                        $s = $sales[$i]+$qty;
                                        array_push($newSales,$s);
                                        $response['success'][] = $item->qty." of ".$product->name." sold";
                                    }
                                }
                                else{ //removing sale...
                                    $s = $sales[$i]-$qty;
                                    array_push($newSales,$s);
                                    $this->removeSale($qty);
                                    $response['success'][] = $qty." sale of ".$values[$i].' of '.$product->name." removed";
                                }
                            }
                            else{ //push the old value
                                array_push($newSales,$sales[$i]);
                            }
                        }
                        $variant->sales = join('|',$newSales);
                        $variant->save();

                        if(empty($response['error'])){
                            if(!$remove){
                                $this->addSale($cart_id,$item);
                            }
                        }
                    }
                }
            }
        }
        return $response;
    }
    






    private function getVariables($request){//This private function is to extract data from variable product and to check for their consistency7
        $response = array(
                'success' => array(),
                'warning' => array(),
                'info' => array(),
                'error' => array(),
                'variant' => null
        );

        if($request->variable !== null && $request->values !== null){//if any of the field is not null
                $initSales = array();
            $values =  explode('|',$request->values);

            $response['variant'] = [
                'variable' => $request->variable,
                'values' => $values,
            ];
        }
        else{
            $response['warning'][] = "Some fields are missing for variant <strong>".$request->variable."</strong>";
        }
        
        return $response;
    }


    //Store new variant
    public function storeVariables($request){
        $response = array(
            'error' => array(),
            'success' => array(),
            'warning' => array(),
            'info' => array(),
                );
        $totalStock = 0;
        $product = Product::find($this->product_id);
        $_v = $this->getVariables($request);
        $response['error'] = array_merge($_v['error'], $response['error']);
        $response['warning'] = array_merge($_v['warning'], $response['warning']);

        if(isset($_v['variant'])){
                $v = $_v['variant'];
                $stocks = array();
                $sales = array();
                $variant = new Variant();
                $variant->product_id = $product->id;

                $normalizedValues = array_map(function($value){ 
                    return str_replace('-','_',str_slug($value));
                },$v['values']);//strip off white spaces

                for($i = 0; $i<count($v['values']); $i++){
                    array_push($stocks, 0);
                    array_push($sales, 0);
                }
                //couple back the values, and stocks
                $variant->variable = str_replace('-','_',str_slug($v['variable']));
                $variant->values = join('|',$normalizedValues);
                $variant->stocks = join('|',$stocks);
                $variant->sales = join('|',$sales);
                $variant->save();
                
                $response['success'][] = $product->name.' added successfully and '.count($v['values']).' variants added';    
        }
        else{
            $response['info'][] = "No variable was added to <strong>$product->name</strong>";
        }
        return $response;
    }


     function report($feedback){
        $report = array();
        if(isset($feedback['success']) && count($feedback['success']) > 0){
            $report['success'] = "<ul class='list-group'>";
            foreach($feedback['success'] as $s){
                $report['success'] .= "<li class='list-group-item text-success'>$s</li>";
            }
            $report['success'] .= "</ul>";
       }

       if(isset($feedback['info']) && count($feedback['info']) > 0){
        $report['info'] = "<ul class='list-group'>";
        foreach($feedback['info'] as $i){
            $report['info'] .= "<li class='list-group-item text-info'>$i</li>";
        }
        $report['info'] .= "</ul>";
   }

       if(isset($feedback['warning']) && count($feedback['warning']) > 0){
            $report['warning'] = "<ul class='list-group'>";
            foreach($feedback['warning'] as $w){
                $report['warning'] .= "<li class='list-group-item text-warning'>$w</li>";
            }
            $report['warning'] .= "</ul>";
        }

        if(isset($feedback['error']) && count($feedback['error']) > 0){
            $report['error'] = "<ul class='list-group'>";
            foreach($feedback['error'] as $e){
                $report['error'] .= "<li class='list-group-item text-danger'>$e</li>";
            }
            $report['error'] .= "</ul>";
        }
        return $report;
    }

}
?>
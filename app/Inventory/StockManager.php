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
                'user_id' => $user,
                'product_id' => $product,
                'operation' => $operation,
                'price' => $price,
                'quantity' => $qty
            ]);
        }

        public function sale($user,$product,$cart,$price,$qty){
            Sale::create([
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
        $remaining = $product->remaining() - $item->qty;
        if($remaining < 0 ){
            return ['error' => ["$item->qty sales of $product->name not feasible, only <strong>".$product->remaining()."</strong> remaining"]];
        }
         else{
            $product->sale = $product->sale + $item->qty;
            $product->save();
            $this->sale(Auth::id(),$product->id,$cart_id,$product->selling_price,$item->qty);
            return ['success' => ["$item->qty sales added to $product->name"]];
         }

    }

    public function removeStock($qty){
        $product = Product::find($this->product_id);
        $product->stock = $product->stock - $qty;
        $product->save();

        $this->action(Auth::id(),$product->id,2,$product->selling_price,$qty);

        return ['success' => ["$qty stocks removed from $product->name"]];
    }
    

    public function removeSale($qty){
        $product = Product::find($this->product_id);
        $product->stock = $product->sale - $qty;
        $product->save();

        $this->action(Auth::id(),$product->id,3,$product->selling_price,$qty);

        return ['success' => ["$qty sales removed from $product->name"]];
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
    public function updateVariableSales($cart_id,$item){
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
                                if($remainings[$i] - $qty < 0){
                                    $response['error'][] = "Sale not feasible, only $remainings[$i] remains";
                                    array_push($newSales,$sales[$i]);
                                }else{
                                     $s = $sales[$i]+$qty;
                                    array_push($newSales,$s);
                                    $response['success'][] = $item->qty." of ".$product->name." sold";
                                }
                            }
                            else{
                                array_push($newSales,$sales[$i]);
                            }
                        }
                        $variant->sales = join('|',$newSales);
                        $variant->save();
                        if(empty($response['error'])){
                            $this->addSale($cart_id,$item);
                        }
                        return $response;
                    }
                }
            }
        }
    }
    






    private function getVariables($request){//This private function is to extract data from variable product and to check for their consistency7
        $response = array(
                'success' => array(),
                'warning' => array(),
                'info' => array(),
                'error' => array(),
                'variant' => null
        );

        if($request->variable !== null && $request->values !== null && $request->v_stocks !== null){//if any of the field is not null
            $initSales = array();
            $values =  explode('|',$request->values);
            $stocks = explode('|',$request->v_stocks);
            if(count($values) === count($stocks)){
                $response['variant'] = [
                    'variable' => $request->variable,
                    'values' => $values,
                    'stocks' => $stocks,
                ];
            }
            else{
                $response['error'][] = "Variable ".$request->variable." could not be added: ".count($values)." values provided, but ".count($stocks)." stocks given"; 
            }
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
                $sales = array();
                $variant = new Variant();
                $variant->product_id = $product->id;

                $normalizedValues = array_map(function($value){ 
                    return str_replace('-','_',str_slug($value));
                },$v['values']);
                
                $normalizedStocks = array();
                $totalStock = 0;
                for($i = 0; $i<count($v['stocks']); $i++){
                    if(is_numeric($v['stocks'][$i])){
                        array_push($normalizedStocks, $v['stocks'][$i]);
                        array_push($sales, 0);
                        $response['success'][] = "<strong>".$v['stocks'][$i]." ".$v['variable']." ".$v['values'][$i]."</strong> of  <strong>$product->name</strong> added";
                        $totalStock += $v['stocks'][$i];
                    }else{//if string was provided, change it to zero
                        array_push($normalizedStocks, 0);
                        $response['warning'][] = "stock input for <strong>".$v['values'][$i]."</strong> is invalid, <strong>0</strong> used instead";
                     }
                }
                //couple back the values, stocks and sales
                $variant->variable = str_replace('-','_',str_slug($v['variable']));
                $variant->values = join('|',$normalizedValues);
                $variant->stocks = join('|',$normalizedStocks);
                $variant->sales = join('|',$sales);
                $variant->save();
                $this->addStock($totalStock);
                $response['success'][] = "$totalStock total stocks added to ".$product->name;    
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
            $report['info'] .= "<li class='list-group-item text-success'>$i</li>";
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
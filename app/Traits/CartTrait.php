<?php 
namespace App\Traits;

use App\Product;
/**
 * 
 */
trait CartTrait
{
    public function arrangeCart($product,$quantity, $options = null){
        $opts = [];
        $infeasibility = array();

        if($product->isSimple()){
            $feasibility = $product->saleFeasible($quantity);//check if the quantity is feasible to be sold
            if($feasibility !== true){
                array_push($infeasibility, 'Cannot add '.$quantity.' of '.$product->name.' to cart, only '.$feasibility.' remaining');
            }
            $qty = $quantity;
        }
        elseif($product->isVariable()){
            $qty = 0;
            if($options == null){ //if the options were not passed, get them from the request
                foreach($product->variants as $variant){
                    $variable = $variant->variable;
                    if(request()->has($variable) && count(request()->$variable) > 0){
                        $opts[$variant->variable] = array();
                        foreach(request()->$variable as $key => $value){ 
                            // $quantity would be an array if product is variable
                            if(isset($quantity[$key]) && $quantity[$key] != null && $quantity[$key] > 0){
                                $v_feasibility = $variant->saleFeasible($value,$quantity[$key]);
                                if($v_feasibility !== true){
                                    array_push($infeasibility, 'Cannot add '.$quantity[$key].' of '.$value.' of '.$product->name.'. Only '.$v_feasibility.' remaining');
                                }else{
                                    $qty += $quantity[$key];
                                    $opts[$variant->variable][$value] = (int) $quantity[$key];
                                }
                            }
                        }
                    }
                }
            }
            else{
                $opts = $options;
            }
           
        }

        if(!$product->sellingPriceSet()){
            array_push($infeasibility, 'Cannot add '.$product->name.' to cart. Selling price not set yet ');
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->selling_price,
            'opts' => $opts,
            'infeasibility' => $infeasibility
        ];
    }
    
}

?>
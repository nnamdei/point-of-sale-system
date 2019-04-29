<?php

namespace App;

use Auth;
use Cart;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{   
    use SoftDeletes;
    use SearchableTrait;
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['category_id','user_id', 'name', 'description', 'stock', 'flat_price', 'sale','selling_price','preview'];

    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 10,
            'categories.name' => 10,
            'products.selling_price' => 10,
            'barcodes.serial' => 10,
            'barcodes.barcode_content' => 10,
        ],
        'joins' => [
            'categories' => ['products.category_id', 'categories.id'],
            'variants' => ['products.id','variants.product_id'],
            'barcodes' => ['products.id','barcodes.product_id']
        ]

        ];
    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function barcodes(){
        return $this->hasMany('App\Barcode');
    }
    public function category_(){
        return Category::withTrashed()->where('id',$this->category_id)->first();
    }

    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }

    public function manager(){
        return $this->user() == null ? null : $this->user()->profile;
    }



    public function variants(){
        return $this->hasMany('App\Variant');
    }
    public function actions(){
        return $this->hasMany('App\Action');
   }

   public function cart_sales(){
    return $this->hasMany('App\Sale');
    }

    public function inShop($shop_id){
        return $this->shop->id == $shop_id ? true : false;
    }

    public function isSimple(){
        return ($this->type == 'simple' ? true : false);
    }

    public function isVariable(){
        return ($this->type == 'variable' ? true : false);
    }
    
    function preview(){
        return $this->preview === null ? asset('storage/images/products/default.png') : asset('storage/images/products/'.$this->preview);
    }

    public function inMyShop(){
        return $this->shop->id == Auth::user()->shop->id ? true : false;
    }

    function inCart(){
       $search = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->id;
        });
        return $search->first();
    }
    public function stocks(){
        $stocks = 0;
        if($this->isSimple()){
            $stocks = $this->stock;
        }
        elseif($this->isVariable()){
            foreach($this->variants as $variant){
                $stocks += $variant->totalStock();
            }
        }
        return $stocks;
    }

    public function sales(){//get the total sales for variable product
        $sales = 0;
        if($this->isSimple()){
            $sales = $this->sale;
        }
        elseif($this->isVariable()){
            foreach($this->variants as $variant){
                $sales += $variant->totalSale();
            }
        }
        return $sales;
    }

    public function remaining(){
        return ($this->stocks() - $this->sales());
    }
    
    public function saleFeasible($qty){
        $remaining = $this->remaining();
        return $remaining >= $qty ? true : $remaining;
    }

    public function profitIndex(){
        if($this->basePriceSet() && $this->sellingPriceSet()){
            return round((($this->selling_price - $this->base_price)/$this->base_price)*100, 2);
        }
        return 0;
    }

    public function basePriceSet(){
        return $this->base_price > 0 ? true : false;
    }
    public function sellingPriceSet(){
        return $this->selling_price > 0 ? true : false;
    }

    public function profitIndexLevel(){
        return $this->profitIndex() <= 0 ? 'poor' : ($this->profitIndex() < 15 ? 'fair' : 'good');
    }

    public function stocksLow(){
        if($this->shop->setting->lowStockWarningActivated()){
            return $this->remaining() <= $this->shop->setting->lowStock() ? true : false;
        }
        return false;
    }

    public function finished(){
        return $this->remaining() > 0 ? false : true;
    }


    public function variables(){
        $var = "";
        if($this->variants->count() > 0){
            $var ="<ul style='text-align: left'>";
            foreach($this->variants as $variant){
                if($variant->hasValues()){
                    $var .= "<li><a href='".route('variants.show',['id'=> $variant->id])."'>$variant->variable</a> (<span class='text-info'>$variant->values</span>)</li>";
                }
                else{
                    $var .= "<li><a href='".route('variants.show',['id'=> $variant->id])."'>$variant->variable</a>  <i class='fa fa-exclamation-triangle'></i> No values <form action='".route('variants.destroy',['id'=>$variant->id])."' method='post'><input type='hidden' name='_token' value='".csrf_token()."'><input type='hidden' name='_method' value='DELETE'> <button type='submit' class='btn btn-link'>discard</button></form>";
                }
            }
            $var .= "</ul>";
        }else{
            $var = "<small class='text-warning'><i class='fa fa-exclamation-triangle'></i>  No variables yet</small>";
        }
        return $var;
    }



    public function inconsistency(){
        $inconsistents = array();
        foreach($this->variants as $variant){
            if(!$variant->isConsistent()){
                array_push($inconsistents, $variant);
            }
        }
        return $inconsistents;
    }

    public function stocksBreakDown(){
        $breakDown = "<ul style='text-align: left'>";
        if($this->isVariable()){
            foreach($this->variants as $v){
                $breakDown .= "<li><a href=\"".route('variants.show',['id'=>$v->id])."\">$v->variable</a>";
                if($v->isConsistent()){
               $breakDown .= "<ul>";
                                   for($z=0; $z<count($v->stocks()); $z++){
                                       $breakDown .= "<li>".$v->values()[$z]." - <span class='badge badge-primary'>".$v->stocks()[$z]."</span></li>";
                                   }
                $breakDown .= "</ul>";
                }
                else{
                    $breakDown .= "<small class='text-danger'><i class='fa fa-exclamation-triangle'></i>  unable to anlyze: inconsistent data</small>";
                }
                $breakDown .= "</li>";
            }
            $breakDown .= "</ul>";
        }
        else{
            $breakDown .= "<li>$this->stock</li>";
        }
        $breakDown .= "</ul>";
        return $breakDown;
    }

    public function salesBreakDown(){
        $breakDown = "<ul style='text-align: left'>";
        if($this->isVariable()){
            foreach($this->variants as $v){
                $breakDown .= "<li><a href=\"".route('variants.show',['id'=>$v->id])."\">$v->variable</a>";
                if($v->isConsistent()){
               $breakDown .= "<ul>";
                                   for($z=0; $z<count($v->sales()); $z++){
                                       $breakDown .= "<li>".$v->values()[$z]." - <span class='badge badge-success'>".$v->sales()[$z]."</span></li>";
                                   }
                $breakDown .= "</ul>";
                }
                else{
                    $breakDown .= "<small class='text-danger'><i class='fa fa-exclamation-triangle'></i>  unable to anlyze: inconsistent data</small>";
                }
                $breakDown .= "</li>";
            }
            $breakDown .= "</ul>";
        }
        else{
            $breakDown .= "<li>$this->sale</li>";
        }
        $breakDown .= "</ul>";
        return $breakDown;
    }

    public function remainsBreakDown(){
        $breakDown = "<ul  style='text-align: left'>";
        if($this->isVariable()){
            foreach($this->variants as $v){
                $breakDown .= "<li><a href=\"".route('variants.show',['id'=>$v->id])."\">$v->variable</a>";
                if($v->isConsistent()){
               $breakDown .= "<ul>";
                                   for($z=0; $z<count($v->remainings()); $z++){
                                       $breakDown .= "<li>".$v->values()[$z]." - <span class='badge badge-secondary'>".$v->remainings()[$z]."</span></li>";
                                   }
                $breakDown .= "</ul>";
                }
                else{
                    $breakDown .= " <small class='text-danger'><i class='fa fa-exclamation-triangle'></i>  unable to anlyze: inconsistent data</small>";
                }
                $breakDown .= "</li>";
            }
            $breakDown .= "</ul>";
        }
        else{
            $breakDown .= "<li>".$this->remaining()."</li>";
        }
        $breakDown .= "</ul>";
        return $breakDown;
    }

}

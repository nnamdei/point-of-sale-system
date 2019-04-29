<?php

namespace App;

use App\Sale;
use Illuminate\Database\Eloquent\Model;

class CartDB extends Model
{
    protected $table = 'shoppingcarts';
    // protected $primaryKey = 'identifier';

    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }
    
    public function attendant(){
        return $this->user() == null ? null : $this->user()->profile();
    }

    //get the sale record of an item in the cart
    public function sale($product_id){
        return Sale::withTrashed()->where([['cart_id', $this->id],['product_id',$product_id]])->first();
    }

}

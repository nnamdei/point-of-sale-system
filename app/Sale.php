<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['shop_id','user_id','product_id','cart_id','price','quantity'];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function product(){
        return Product::withTrashed()->where('id',$this->product_id)->first();
    }

    public function trashed(){
        return $this->deleted_at == null ? false : true;
    }
    
    public function cart(){
        return $this->belongsTo('App\CartDB');
    }
    
    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }
    
    public function attendant(){
        return $this->user() == null ? null : $this->user()->profile();
    }


}

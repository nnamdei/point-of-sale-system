<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sale extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
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

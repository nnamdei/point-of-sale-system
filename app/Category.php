<?php

namespace App;

use Auth;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['shop_id','user_id','name', 'description'];

    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }
    
    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function inMyShop(){
        return $this->shop->id == Auth::user()->shop->id ? true : false;
    }

}

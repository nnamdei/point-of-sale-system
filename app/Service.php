<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'shop_id','name', 'description', 'price'];

    
    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }
    
    public function shop(){
        return $this->belongsTo('App\Shop');
    }
    
    public function records(){
        return $this->hasMany('App\ServiceRecord');
    }

    public function inMyShop(){
        return $this->shop->id == Auth::user()->shop->id ? true : false;
    }

}

<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id', 'shop_id', 'staff_id', 'name', 'description', 'price'];

    
    public function user(){
        return $this->belongTo('App\User');
    }

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function staff(){
        return $this->belongTo('App\Staff');
    }
    
    public function records(){
        return $this->hasMany('App\ServiceRecord');
    }

    public function inMyShop(){
        return $this->shop->id == Auth::user()->shop->id ? true : false;
    }

}

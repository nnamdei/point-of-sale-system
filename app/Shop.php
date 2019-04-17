<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['shop_id','name','address','phone','email','about'];

    public function staff(){
        return $this->hasMany('App\Staff');
    }

    public function manager(){
        return $this->staff()->where('position','manager')->first();
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
    public function sales(){
        return $this->hasMany('App\Sale');
    }
    public function activities(){
        return $this->hasMany('App\Action');
    }
    public function categories(){
        return $this->hasMany('App\Category');
    }

    public function services(){
        return $this->hasMany('App\Service');
    }
    public function serviceRecords(){
        return $this->hasMany('App\ServiceRecord');
    }

    public function setting(){
        return $this->hasOne('App\ShopSetting');
    }
    public function hasManager(){
        return $this->manager() == null ? false : true;
    }
    public function checkedIn(){
        return Auth::user()->hasShop() && $this->id == Auth::user()->shop->id ? true : false;
    }

    public function todaySales(){
        return $this->sales()
                    ->whereDate('created_at',Carbon::now()->format('Y-m-d'));
    }

    public function todayServiceRecords(){
        return $this->serviceRecords()
                        ->whereDate('created_at',Carbon::now()->format('Y-m-d'));

    }

    public function lowStockProducts(){
       $products = array();
       foreach($this->products as $product){
           if($product->remaining() <= $this->setting->lowStock()){
               array_push($products, $product);
           }
       }
       return collect($products);
    }
}

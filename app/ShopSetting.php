<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    protected $fillable = [
        'shop_id',
        'theme',
        'activation',
        'product_activation',
        'service_activation',
        'low_stock_warning_activation',
        'low_stock',
        'scanner_activation',
    ];

    public function shop(){
    return $this->belongsTo('App\Shop');
    }
    public function theme(){
    return $this->theme;
    }
    public function activated(){
    return $this->activation == 1 ? true : false;
    }
    public function productActivated(){
    return $this->product_activation == 1 ? true : false;
    }
    public function serviceActivated(){
    return $this->service_activation == 1 ? true : false;
    }
    public function scannerActivated(){
    return $this->scanner_activation == 1 ? true : false;
    }
    public function lowStockWarningActivated(){
    return $this->low_stock_warning_activation == 1 ? true : false;
    }
    public function lowStock(){
    return $this->low_stock;
    }
}

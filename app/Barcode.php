<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $fillable = ['product_id', 'serial','attribute', 'barcode','barcode_content','src'];

    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function read(){
        return $this->product->name.' '.$this->attribute;
    }
    public function isGenerated(){
        return $this->src == 'generated' ? true : false;
    }
    public function isAttached(){
        return $this->src == 'attached' ? true : false;
    }
}

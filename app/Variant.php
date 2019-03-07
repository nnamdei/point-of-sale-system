<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = ['product_id', 'variable', 'value', 'count'];

    public function product(){
        return $this->belongsTo('App\Product');
    }


    public function values(){
        return explode('|',$this->values);
    }
    public function stocks(){
        return explode('|',$this->stocks);
    }
    public function totalStock(){
        return array_sum($this->stocks());
    }

    public function sales(){
        return explode('|',$this->sales);
    }
    public function totalSale(){
        return array_sum($this->sales());
    }
 
    public function remainings(){
        $remainings = array_map(function($stock,$sale){
            return $stock - $sale;
        },$this->stocks(),$this->sales());

        return $remainings;
    }
    public function totalRemaining(){
        return $this->total($this->remainings());
    }
//explode() function used to extract values,stocks and sales from a variable always return
//array of size 1 event if the string is empty, this is to confirm if there are truly values
//available for a variable i.e not empty. 
    public function hasValues(){ 
        return (count($this->values()) > 0 && $this->values()[0] !== '' ? true : false);
    }

    public function isConsistent(){
        return (count($this->values()) === count($this->stocks()) && count($this->values()) === count($this->sales())  ? true : false);
    }
}

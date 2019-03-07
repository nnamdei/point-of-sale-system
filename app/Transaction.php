<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['product_id','user_id','operation','price','quantity'];

    public function product(){
        return $this->belongsTo('App\Product');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function interprete(){
        switch($this->operation){
            case 1:
                return "<span class='badge badge-secondary'>$this->quantity</span> stocks added to <a href='".route('products.show',['id'=>$this->product->id])."'>".$this->product->name."</a>";
            break;
            case 2:
                return "<span class='badge badge-secondary'>$this->quantity</span> of <a href='".route('products.show',['id'=>$this->product->id])."'>".$this->product->name."</a> sold";
            break;
            
            case 3:
                return "<span class='badge badge-secondary'>$this->quantity</span> stocks removed from <a href='".route('products.show',['id'=>$this->product->id])."'>".$this->product->name."</a>";
            break;
            
            case 4:
                return "<a href='".route('products.show',['id'=>$this->product->id])."'>".$this->product->name."</a> price changed from $this->price to ".$this->product->selling_price;
            break;
            
            default:
                return "Unrecognized action";
            break;
            
          
        }
    }
}


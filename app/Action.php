<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['user_id','product_id','operation','price','quantity'];
    
    public function product(){
        return Product::withTrashed()->where('id',$this->product_id)->first();
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function interprete(){
        switch($this->operation){
            case 1:
                return 
                $this->product()->trashed()
                                     ? 
                                    "<span>$this->quantity</span> stocks added to <span  class='text-danger' data-toggle='tooltip' title='deleted ".$this->product()->deleted_at->toDayDateTimeString()."'>".$this->product()->name."</span>" 
                                    :
                                    "<span class='theme-color'>$this->quantity</span> stocks added to <a href='".route('products.show',['id'=>$this->product()->id])."'>".$this->product()->name."</a>"; 
            break;
            case 2:

                return 
                $this->product()->trashed()
                ? 
               "<span>$this->quantity</span> stocks removed from <span class='text-danger' data-toggle='tooltip' title='deleted ".$this->product()->deleted_at->toDayDateTimeString()."'>".$this->product()->name."</span>" 
               :
                "<span class='theme-color'>$this->quantity</span> stocks removed from <a href='".route('products.show',['id'=>$this->product()->id])."'>".$this->product()->name."</a>";
            break;
            
            case 3:
                return
                    $this->product()->trashed()
                    ? 
                    "<span>$this->quantity</span> sales removed from <span  class='text-danger' data-toggle='tooltip' title='deleted ".$this->product()->deleted_at->toDayDateTimeString()."'>".$this->product()->name."'>".$this->product()->name."</span>" 
                    :
                    "<span class='theme-color'>$this->quantity</span> sales removed from <a href='".route('products.show',['id'=>$this->product()->id])."'>".$this->product()->name."</a>";
            break;
            
            case 4:
                return
                $this->product()->trashed()
                ? 
                "<span  class='text-danger' data-toggle='tooltip' title='deleted  ".$this->product()->deleted_at->toDayDateTimeString()."'>".$this->product()->name."</span>  price changed from $this->price"
                :
                "<a href='".route('products.show',['id'=>$this->product()->id])."'>".$this->product()->name."</a> price changed from $this->price";
            break;
            case 5:
            return
                $this->product()->trashed()
                ? 
                "<span  class='text-danger' data-toggle='tooltip' title='deleted  ".$this->product()->deleted_at->toDayDateTimeString()."'>".$this->product()->name."</span>  was reset"
                :
                "<a href='".route('products.show',['id'=>$this->product()->id])."'>".$this->product()->name."</a> was reset";
            break;

            default:
                return "Unrecognized action";
            break;
            
          
        }
    }
}

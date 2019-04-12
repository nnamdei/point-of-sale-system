<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['shop_id','name','address','about'];

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

    public function hasManager(){
        return $this->manager() == null ? false : true;
    }

}

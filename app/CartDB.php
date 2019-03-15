<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDB extends Model
{
    protected $table = 'shoppingcart';
    // protected $primaryKey = 'identifier';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function attendant(){
        return $this->user;
    }
}

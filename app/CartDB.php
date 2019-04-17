<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDB extends Model
{
    protected $table = 'shoppingcarts';
    // protected $primaryKey = 'identifier';

    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }
    
    public function attendant(){
        return $this->user() == null ? null : $this->user()->profile();
    }

}

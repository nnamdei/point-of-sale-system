<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['user_id','name', 'description'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function products(){
        return $this->hasMany('App\Product');
    }
}

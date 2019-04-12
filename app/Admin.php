<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id', 'firstname', 'lastname', 'email','level'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }


    public function fullname(){
        return $this->firstname.' '.$this->lastname;
    }
    public function avatar(){
        return asset('storage/images/users/default.png');
    }

}

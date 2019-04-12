<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id','shop_id','firstname', 'lastname', 'email','avatar','position'
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function service_records(){
        return $this->hasMany('App\ServiceRecord');
    }

    public function fullname(){
        return $this->firstname.' '.$this->lastname;
    }

    function isManager(){
        return $this->position == 'manager' ? true : false;
    }

    function isAttendant(){
        return $this->position == 'attendant' ? true : false;
    }
    
    function isRegularStaff(){
        return !$this->isAttendant() && !$this->isManager() ? true : false;
    }

    public function avatar(){
        return $this->avatar === null ? asset('storage/images/users/default.png') : asset('storage/images/users/'.$this->avatar);
    }

}

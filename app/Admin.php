<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'firstname', 'lastname', 'email','level'
    ];

    public function user(){
        return $this->hasOne('App\User');
    }


    public function fullname(){
        return $this->firstname.' '.$this->lastname;
    }
    public function avatar(){
        return asset('storage/images/users/default.png');
    }

    public function isSuperAdmin(){
        return $this->level == 'superadmin' ? true : false;
    }
    
    public function trashed(){
        return $this->deleted_at == null ? false : true;
    }


}

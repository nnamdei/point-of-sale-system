<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function categories(){
        return $this->hasMany('App\Category');
   }
   public function transactions(){
        return $this->hasMany('App\Transaction');
   }

   public function fullname(){
       return $this->firstname.' '.$this->lastname;
   }

   function isAttendant(){
        return $this->position == 0 ? true : false;
   }

   function isManager(){
        return $this->position == 1 ? true : false;
    }
    function avatar(){
        return $this->avatar === null ? asset('storage/images/users/default.png') : asset('storage/images/users/'.$this->avatar);
    }
    function position(){
        switch ($this->position){
            case 0:
                return "Attendant";
            break;
            case 1:
                return "Manager";
            break;
            default:
            return "Unknown";
            break;

        }
    }
}


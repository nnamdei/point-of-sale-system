<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['desk_closed_at'];
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

  public function actions(){
        return $this->hasMany('App\Action');
   }

   public function sales(){
    return $this->hasMany('App\Sale');
    }
   
   public function carts(){
       return $this->hasMany('App\CartDB');
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
    
    public function deskClosed(){
        return $this->desk_closed_at == null ? false : true;
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


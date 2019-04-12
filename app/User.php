<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable,softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['desk_closed_at'];
    protected $fillable = [
       'shop_id','email', 'role', 'password','dest_closed_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }
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

   public function services_recorded(){
        return $this->hasMany('App\ServiceRecord');
    }

    public function profile(){
       switch($this->role){
           case 'staff':
            return $this->hasOne('App\Staff');
           break;

           case 'admin':
                return $this->hasOne('App\Admin');
            break;
        }
    }

    public function fullname(){
       return $this->firstname.' '.$this->lastname;
    }

    public function hasShop(){
        return $this->shop_id == null || $this->shop == null ? false : true;
    }
    public function otherShops(){
        return Shop::where('id','!=',$this->shop->id)->get();
    }
    public function isAdmin(){
        return $this->role == 'admin' ? true : false;
    }

    public function isManager(){
        return $this->isStaff() && $this->profile->isManager() ? true : false;
    }

    public function isAdminOrManager(){
        return $this->isAdmin() || $this->isManager() ? true : false;
    }


    public function isAttendant(){
        return $this->isStaff() && $this->profile->isAttendant() ? true : false;
    }

    public function isStaff(){
       return $this->role == 'staff' ? true : false;
    }

    public function deskClosed(){
        return $this->desk_closed_at == null ? false : true;
    }
    
}


<?php

namespace App;

use App\Admin;
use App\Staff;
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
    protected $dates = ['desk_closed_at','deleted_at'];
    protected $fillable = [
       'shop_id','staff_id','admin_id','email', 'password','dest_closed_at',
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
    public function admin(){
        return $this->belongsTo('App\Admin');
    }
    public function staff(){
        return $this->belongsTo('App\Staff');
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
    public function isSuperAdmin(){
        return $this->isAdmin() && $this->profile()->isSuperAdmin() ? true : false;
    }
    public function isAdmin(){
        return $this->admin_id == null || $this->admin == null ? false : true;
    }
    public function isStaff(){
        return $this->staff_id == null || $this->staff == null ? false : true;
     }
 
    public function isManager(){
        return $this->isStaff() && $this->profile()->isManager() ? true : false;
    }
    public function isAttendant(){
        return $this->isStaff() && $this->profile()->isAttendant() ? true : false;
    }

    public function isAdminOrManager(){
        return $this->isAdmin() || $this->isManager() ? true : false;
    }

    public function profile(){
       if($this->isAdmin()){
            return Admin::withTrashed()->where('id',$this->admin_id)->first();
        }
        elseif($this->isStaff()){
            return Staff::withTrashed()->where('id',$this->staff_id)->first();
        }
        return null;
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
    public function deskClosed(){
        return $this->desk_closed_at == null ? false : true;
    }
    
    public function revoked(){
        return $this->deleted_at == null ? false : true;
    }
}


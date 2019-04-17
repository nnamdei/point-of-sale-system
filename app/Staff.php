<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
       'shop_id','firstname', 'lastname', 'email','avatar','position'
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }
    
    public function user(){
        return User::withTrashed()->where('staff_id',$this->id)->first();
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

    public function trashed(){
        return $this->deleted_at == null ? false : true;
    }
    public function avatar(){
        return $this->avatar === null ? asset('storage/images/users/default.png') : asset('storage/images/users/'.$this->avatar);
    }

    public function totalSalesToday(){
        $total_sales = 0;

        if($this->user() != null){
            $sales = $this->sales()
                            ->whereDate('created_at',Carbon::now()->format('Y-m-d'))
                            ->where('user_id', $this->user()->id)
                            ->get();
        }
        foreach($sales as $sale){
            $total_sales += ($sale->price * $sale->quantity);
        }
        return $total_sales;
    }



}

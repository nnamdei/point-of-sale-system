<?php

namespace App;

use App\User;
use App\Staff;
use App\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = ['identifier','shop_id','user_id', 'staff_id', 'service_id', 'note', 'paid','payment','customer_name', 'customer_phone'];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function user(){
        return User::withTrashed()->where('id',$this->user_id)->first();
    }

    public function attendant(){
        return $this->user() == null ? null : $this->user()->profile();
    }

    public function staff(){
        return Staff::withTrashed()->where('id',$this->staff_id)->first();
    }
    public function service(){
        return Service::withTrashed()->where('id',$this->service_id)->first();
    }

    public function trashed(){
        return $this->deleted_at == null ? false : true;
    }
}

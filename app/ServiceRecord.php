<?php

namespace App;

use App\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = ['shop_id','user_id', 'staff_id', 'service_id', 'note', 'paid','customer_name', 'customer_phone'];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function staff(){
        return $this->belongsTo('App\Staff');
    }

    public function service(){
        return Service::withTrashed()->where('id',$this->service_id)->first();
    }

    public function trashed(){
        return $this->deleted_at == null ? false : true;
    }
}

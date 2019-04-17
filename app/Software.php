<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = 'software_info';

    protected $dates = ['cache_expires'];


    protected $fillable = ['name','version','package','status','cache_age','cache_expires'];

    public function isPremium(){
        return $this->package == 'premium' ? true : false;
    }
    public function isActive(){
        return $this->status == 'active' ? true : false;
    }
    public function cacheExpired(){
        return $this->cache_expires <= now() ? true : false;
    }
    public function updateCache(){
        $this->cache_expires = now()->addDays(3);
        $this->save();
    }
}

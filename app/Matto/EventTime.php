<?php
namespace App;
use DateTime;

class EventTime{
    protected $start;
    protected $end;

    public function __construct($start,$end){
        $this->start = $start;
        $this->end = $end;
    }

    public function now(){
        return new DateTime();
    }

    public function startDate(){
        return new DateTime($this->start);
    }

    public function endDate(){
        return new DateTime($this->end);
    }
    
    public function isUpcoming(){  
        if($this->startDate() > $this->now()){
            return true;
        }
        return false;
    }

    public function beforeStart(){
         return $this->now()->diff($this->startDate());
    }

    public function afterStart(){
        return $this->startDate()->diff($this->now());
    }
    public function howFar(){
        $howfar = " ";
        $days = $this->afterStart()->d;
        $hours = $this->afterStart()->h;
        $minutes = $this->afterStart()->i;
        $seconds = $this->afterStart()->s;

        if($days > 0){
            $howfar = "$days days ago";
        }
        else if($hours > 0){
            $howfar = "$hours h, $minutes min ago";
        }
        else if($minutes > 0){
            $howfar = "$minutes min ago";
        }
        else{
            $howfar = "$seconds seconds ago";
        }
        return $howfar;
    }

    public function beforeEnd(){
        return $this->now()->diff($this->endDate());
   }
}
   ?>
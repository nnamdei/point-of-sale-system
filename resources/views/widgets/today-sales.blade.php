<?php
    $SALES = 0;
    $_today = new DateTime();
    if(Auth::user()->isManager()){
        $_s = $_sale::whereDate('created_at',$_today->format('Y-m-d'))
                            ->get();//get all the sales by all attendants
    }
    else{
        $_s = $_sale::whereDate('created_at',$_today->format('Y-m-d'))
                            ->where('user_id',Auth::id())
                            ->get();//get the sales recorded by the current attendant
    }

	foreach($_s as $s){
		$SALES += ($s->price * $s->quantity);
	}
?>
<div data-toggle="tooltip" data-placement="top" title="sales today" class="badge badge-success text-center" style="font-size: 25px" >{{number_format($SALES)}}</div>

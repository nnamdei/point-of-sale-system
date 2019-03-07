<?php
    $SALES = 0;
    $_today = new DateTime();
    if(Auth::user()->isManager()){
        $_s = $TRANSACTIONS->whereDate('created_at',$_today->format('Y-m-d'))
                            ->where('operation',2)
                            ->get();//get all the sales by all attendants
    }
    else{
        $_s = $TRANSACTIONS->whereDate('created_at',$_today->format('Y-m-d'))
                            ->where('user_id',Auth::id())
                            ->where('operation',2)
                            ->get();//get the sales recorded by the current attendant
    }

	foreach($_s as $s){
		$SALES += ($s->price * $s->quantity);
	}
?>
<div class="animated swing infinite slow" data-toggle="tooltip" data-placement="top" title="sales today" class="badge badge-success" style="font-size: 25px" >&#8358; {{number_format($SALES)}}</div>

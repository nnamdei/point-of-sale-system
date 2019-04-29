<?php

    $SALES = 0;
    $sales_collection = collect([]);
    $SERVICES_CHARGES = 0;
    $service_record_collection = collect([]);

        if(Auth::user()->isAttendant()){
            $sales_collection = $shop->todaySales()
                                    ->where('user_id', Auth::id())
                                    ->get();
            $service_record_collection = $shop->todayServiceRecords()
                                        ->where('user_id', Auth::id())
                                        ->groupBy('service_id')
                                        ->select(DB::raw('sum(paid) as total,staff_id,service_id'))
                                        ->get();
        
        }elseif(Auth::user()->isAdminOrManager()){
            $sales_collection = $shop->todaySales()
                                    ->groupBy('product_id')
                                    ->select(DB::raw('sum(quantity) as total, price,user_id,product_id'))
                                    ->get();
            $service_record_collection = $shop->todayServiceRecords()
                                        ->groupBy('service_id')
                                        ->select(DB::raw('sum(paid) as total,staff_id,service_id'))
                                        ->get();
        }

    foreach($sales_collection as $s){
        $SALES += $s->price * $s->total;
    }

    foreach($service_record_collection as $r){
        $SERVICES_CHARGES += $r->total;
    }
?>
<div class="">
    <div class="bg-white shadow-md">
        <div class="py-3 text-center">
            <h6 class="theme-color">Wallet Today</h6>
        </div>
        <div class="p-2 theme-bg ">
            @if($shop->setting->productActivated())
                <div class="text-center">
                    <h6 class="">Sales</h6>
                    @if(Auth::user()->isAdminOrManager())
                        <div class="dropdown">
                                <span class="dropdown-toggle" id="today-sales-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <span data-toggle="tooltip" data-placement="top" title="Total sales today in {{$shop->name}}" style="font-size: 25px">&#8358; {{number_format($SALES)}}</span>
                                </span>
                                <div class="dropdown-menu" aria-labelledby="today-sales-dropdown" style="max-height: 300px;overflow: auto">
                                    @if($sales_collection->count() > 0)
                                        <div style="max-height: 50vh; overflow: auto">
                                            @foreach($sales_collection as $_s)
                                                <div class="dropdown-item">
                                                    <div class="d-flex">
                                                        <div>
                                                            <img src="{{$_s->product()->preview()}}" alt="" width="30px" height="30px" class="product-preview">
                                                            <a href="{{route('products.show',[$_s->product()->id])}}">{{$_s->product()->name}}</a>
                                                            @include('staff.templates.auth-user-name',['user' => $_s->user()])
                                                        </div>
                                                        <div class="ml-auto">
                                                            <h6>&#8358; {{number_format($_s->price * $_s->total)}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>
                                            @endforeach
                                        </div>
                                        <a class="dropdown-item" href="{{route('transactions')}}">see all transactions</a>
                                    @else
                                        <div class="p-2 text-center text-muted"><i class="fa fa-exclamation-triangle"></i>No sale today</div>
                                    @endif
                                </div>
                        </div>
                    @elseif(Auth::user()->isAttendant())
                        <span data-toggle="tooltip" data-placement="top" title="Total sales today in {{$shop->name}}" style="font-size: 25px">&#8358; {{number_format($SALES)}}</span>
                    @endif
                </div>
            @endif

            @if($shop->setting->serviceActivated())
                <div class="text-center">
                    <h6 class="">Service charges</h6>
                        <div class="dropdown">
                            <span class="dropdown-toggle" href="#" id="today-services-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <span data-toggle="tooltip" data-placement="top" title="Total service charges today in {{$shop->name}}" style="font-size: 25px">&#8358; {{number_format($SERVICES_CHARGES)}}</span>
                            </span>
                            <div class="dropdown-menu" aria-labelledby="today-services-dropdown" style="max-height: 300px;overflow: auto">
                                @if($service_record_collection->count() > 0)
                                    <div style="max-height: 50vh; overflow: auto">
                                        @foreach($service_record_collection as $_r)
                                            <div class="dropdown-item">
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{route('service.show',[$r->service()->id])}}">{{$r->service()->name}}</a>
                                                        @include('staff.templates.staff-name',['staff' => $_r->staff()])
                                                    </div>
                                                    <div class="ml-auto">
                                                        <h6>&#8358; {{ number_format($_r->total)}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                        @endforeach
                                    </div>
                                    <a class="dropdown-item" href="{{route('transactions')}}">see all transactions</a>
                                @else
                                    <div class="p-2 text-center text-muted"><i class="fa fa-exclamation-triangle"></i>No service today</div>
                                @endif
                            </div>
                        </div>
                </div>
            @endif
        </div>
    </div>

    @if($shop->setting->productActivated() && $shop->setting->serviceActivated())
        <div class="card-footer">
            <h6>Total: &#8358; {{number_format($SALES + $SERVICES_CHARGES)}}</h6>
        </div>
    @endif 


</div>

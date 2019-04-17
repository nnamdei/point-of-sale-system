<table class="table table-light table-bordered">
    <thead >
        <tr class="bg-white" >
            <td class="text-center " colspan="4" style="border:0">
                <h5 class="theme-color"><i class="fa fa-calendar theme-color"></i> {{$period}}</h5>
            </td>
            <?php
                $totalServiceCharge = 0;
                foreach($service_records as $sale_record){
                    $totalServiceCharge += $sale_record->paid;
                }
            ?>
            <td colspan="2" style="border:0"><h2><span class="" data-toggle="tooltip" title="Total service charge: {{$period}}">&#8358;{{number_format($totalServiceCharge)}}</span></h2></td>
        </tr>
        <tr class="theme-bg border-0">
            <td>Service</td>
            <td>Ammount paid</td>
            <td>Served by</td>
            <td>Attendant</td>
            <td>Customer name</td>
            <td>Customer phone</td>
            <td>Receipt</td>
        </tr>
    </thead>
    <tbody>
    @if($service_records->count() > 0)
        @foreach($service_records as $service_record)
                <tr>
                    <td>
                        @if($service_record->service()->trashed())
                            <span class="text-danger" data-toggle="tooltip" title="service trashed since {{$service_record->service()->deleted_at->toDayDateTimeString()}}">{{$service_record->service()->name}} <i class="fa fa-exclamation-triangle animated flash infinite slow"></i></span>
                        @else
                            <a href="{{route('service.show',[$service_record->service()->id])}}">{{$service_record->service()->name}}</a>
                            <strong class="d-block text-right">&#8358;{{number_format($service_record->service()->price)}}</strong>
                        @endif
                    </td>
                    <td class="text-center">
                        <strong>&#8358;{{number_format($service_record->paid)}}</strong>
                    </td>
                    <td>
                        @include('staff.templates.staff-name',['staff' => $service_record->staff()])
                    </td>
                    <td>
                        @include('staff.templates.auth-user-name',['user' => $service_record->user()])
                    </td>
                    <td>{{$service_record->customer_name}}</td>
                    <td>{{$service_record->customer_phone}}</td>
                    <td>
                    <a href="{{route('receipt.verify',['receipt' => 'service','ref'=>$service_record->identifier])}}">{{$service_record->identifier}}</a>
                    <p class="text-right grey" style="margin: 0">
                        <small><i class="fa fa-clock"></i> {{$service_record->created_at->toDayDateTimeString()}}, {{$service_record->created_at->diffForHumans()}}</small>
                    </p>
                </td>

                </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" >
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                    No service
                </div>
            </td>
        </tr>
    @endif
    </tbody>
</table>

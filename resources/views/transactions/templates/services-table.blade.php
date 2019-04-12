<table class="table table-light table-bordered">
    <thead >
        <tr class="white-bg" >
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
        <tr class="theme-secondary-bg">
            <td>Service</td>
            <td>Ammount paid</td>
            <td>Served by</td>
            <td>Attendant</td>
            <td>Customer name</td>
            <td>Customer phone</td>
        </tr>
    </thead>
    <tbody>
    @if($service_records->count() > 0)
        @foreach($service_records as $service_record)
                <tr>
                    <td>
                        <a href="{{route('service.show',[$service_record->service()->id])}}">{{$service_record->service()->name}}</a>
                        <strong class="d-block tex-right">{{number_format($service_record->service()->price)}}</strong>
                    </td>
                    <td>
                        <strong>{{number_format($service_record->paid)}}</strong>
                    </td>
                    <td>
                        <a href="{{route('staff.show',[$service_record->staff->id])}}">{{$service_record->staff->fullname()}}</a>
                    </td>
                    <td>
                        {{$service_record->user->profile->fullname()}}
                    </td>
                    <td>{{$service_record->customer_name}}</td>
                    <td>{{$service_record->customer_phone}}</td>
                </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center"><i class="fa fa-info-circle"></i>  No service</td>
        </tr>
    @endif
    </tbody>
</table>

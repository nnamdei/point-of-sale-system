@extends('layouts.service-receipt')

@section('service')

    @if(isset($service_record) && $service_record != null)
        <div class="text-center">
            <h4>{{$service_record->service()->name}}</h4>
            <small>{{$service_record->service()->description}}</small>
            <h1>N {{number_format($service_record->paid)}}</h1>
        </div>
    @else
        <h4 class="text-center">No record</h4>
    @endif
    
@endsection
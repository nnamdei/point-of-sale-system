@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-5">
            @if(isset($service_record))
                <div class="card shadow-lg mt-2">
                    <div class="card-body">
                        <h5>Ref: {{$service_record->identifier}}</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                Service: 
                                @if(!$service_record->service()->trashed())
                                    <a href="{{route('service.show',[$service_record->service()->id])}}">{{$service_record->service()->name}}</a>
                                @else
                                    <span class="text-danger" data-toggle="tooltip" title="service trashed since {{$service_record->service()->deleted_at->toDayDateTimeString()}}">{{$service_record->service()->name}} <i class="fa fa-exclamation-triangle animated flash infinite slow"></i></span>
                                @endif
                            </div>
                            <div class="list-group-item">
                                Staff: 
                                @include('staff.templates.staff-name',['staff' => $service_record->staff()])
                            </div>

                            <div class="list-group-item">
                                Attendant: 
                                @include('staff.templates.auth-user-name',['user' => $service_record->user()])
                            </div>
                            <div class="list-group-item">
                                <i class="fa fa-calendar"></i> {{$service_record->created_at->toDayDateTimeString()}}, {{$service_record->created_at->diffForHumans()}}
                            </div>
                            <div class="list-group-item">
                                Payment: {{$service_record->payment}}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-lg py-3 text-danger text-center">
                        <h1><i class="fa fa-exclamation-triangle"></i></h1>
                        <h4>No service receipt was found with ref <i><q>{{$ref}}</q></i></h4>
                    </div>
            @endif
        </div>
    </div>
@endsection



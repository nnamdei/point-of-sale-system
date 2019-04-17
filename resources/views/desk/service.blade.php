@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="card mt-1" >
        <div class="card-header">
            <div class="d-flex">
                <h6>{{$service->name}}</h6>
                <div class="ml-auto">&#8358; {{number_format($service->price)}}</div>
            </div>
        </div>
        <div class="card-body">
            @if($service->description == null)
                <div class="alert alert-warning text-center">
                    No description
                </div>
            @else
                {{$service->description}}
            @endif
        </div>
    </div>
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col">
            <div class="mt-2">
                <div class="card shadow-lg" >
                    <div class="card-header">
                        <h6>New record</h6>
                    </div>
                    <div class="card-body">
                        @include('service.widgets.new-record')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('RHS')
    <?php 
        $services_w_title = 'Other services in '.$service->shop->name;
        $services_w = Auth::user()->shop->services()->where('id', '!=', $service->id)->orderBy('name','asc')->get();
     ?>
     <div class="mt-1">
        @include('widgets.services')
     </div>
@endsection

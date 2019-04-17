@extends('layouts.appRHSfixed')

@section('main')
    <div class="card shadow-lg" >
        <div class="card-header">
            <div class="d-flex">
                <h6>{{$service->name}}</h6>
                <div class="ml-auto">&#8358; {{number_format($service->price)}}</div>
            </div>
            @if(Auth::user()->isAdminOrManager())
                @include('service.widgets.operations')
            @endif
        </div>
        <div class="card-body">
            @if($service->description == null)
                <div class="alert alert-warning text-center">
                    No description
                </div>
            @else
                {{$service->description}}
            @endif
            @include('transactions.widgets.filter')
            @include('transactions.widgets.services')
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

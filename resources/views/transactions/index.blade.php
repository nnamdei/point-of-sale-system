@extends('layouts.appRHSfixed')

@section('main')
    <div style="overflow: auto">
        @include('transactions.widgets.filter')
        @if(Auth::user()->shop->setting->productActivated() && Auth::user()->shop->setting->serviceActivated())
            @include('transactions.widgets.sales-services-tab')
        @elseif(Auth::user()->shop->setting->productActivated())
            @include('transactions.widgets.sales')
        @elseif(Auth::user()->shop->setting->serviceActivated())
            @include('transactions.widgets.services')
        @else
            @include('product.templates.not-enabled')
            @include('service.templates.not-enabled')
        @endif

    </div>
@endsection
@section('RHS')
    <div class="rhs-fixed-head theme-bg" style="padding: 20px">
        <h4>Other Activities</h4>
        <div class="text-right">
            <small>{{$period}}</small>
        </div>
    </div>
    <div class="rhs-body">
        @include('transactions.widgets.activities')
    </div>
@endsection

@section('h-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection
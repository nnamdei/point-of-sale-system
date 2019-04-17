@extends('layouts.appRHSfixed')

@section('main')
    <div class="pt-1" style="overflow: auto">
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
<div class="pt-1">
    @include('widgets.categories')
</div>
@endsection

@section('h-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection
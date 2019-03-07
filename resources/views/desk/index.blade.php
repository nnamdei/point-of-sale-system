@extends('layouts.appRHSfixed')

@section('main')
    <div style="margin-top: 5px">
        @include('transactions.widgets.sales')
    </div>
@endsection

@section('RHS')
<div style="margin-top: 5px">
    @include('widgets.categories')
</div>
@endsection

@section('head-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection
@extends('layouts.appRHSfixed')

@section('main')
    @include('transactions.widgets.filter')
    @include('transactions.widgets.sales')
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
@extends('layouts.appRHSfixed')

@section('main')
    <div class="pt-1" style="overflow: auto">
        @include('transactions.widgets.sales')
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
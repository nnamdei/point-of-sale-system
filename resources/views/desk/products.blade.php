@extends('layouts.appRHSfixed')

@section('main')

    <h5>Products</h5>
    <div style="overflow: auto">
        @include('desk.widgets.products-table')
    </div>
@endsection

@section('RHS')
    <div class="mt-1">
        @include('widgets.categories')
    </div>

@endsection


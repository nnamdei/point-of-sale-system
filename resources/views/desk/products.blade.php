@extends('layouts.appRHSfixed')

@section('main')

    <h2>Products</h2>
    @include('desk.widgets.products-table')
@endsection

@section('RHS')
    <div class="mt-2">
        @include('widgets.categories')
    </div>

@endsection


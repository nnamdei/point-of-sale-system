@extends('layouts.appRHSfixed')

@section('main')

    <h2>Products</h2>
    @include('desk.widgets.products-table')
@endsection

@section('RHS')
    @include('widgets.categories')

@endsection


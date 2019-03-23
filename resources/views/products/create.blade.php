@extends('layouts.appLHSfixedRHSfixed')
@section('LHS')
    <div class="d-none d-sm-block pt-1">
        @include('widgets.products')
    </div>
@endsection
@section('main')
    <div class="card" style="margin-top: 5px">
        <div class="card-header theme-bg">
            <h5>Add New Product</h5>
        </div>
        <div class="card-body">
            @include('forms.new-product')
        </div>
    </div>
@endsection

@section('RHS')
        <div style="padding-top: 5px">
            @include('widgets.categories')
        </div>
           
@endsection


@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="card">
        <div class="card-header">
            <h4>Cart Info</h4>
        </div>
        <div class="card-body">
            <h1>Items: <span class="badge badge-primary">{{Cart::count()}}</span></h1>
        </div>
    </div>
@endsection
@section('main')
    <table class="table table-striped"></table>
@endsection

@section('RHS')

    <div style="margin-top: 5px">
        @include('widgets.products')
    </div>
   
@endsection
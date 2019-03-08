@extends('layouts.appLHSfixed')

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
    <h5>Products in cart</h5>
    <table class="table table-striped">
        
    </table>
@endsection

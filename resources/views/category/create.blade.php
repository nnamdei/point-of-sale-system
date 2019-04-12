@extends('layouts.appLHSfixedRHSfixed')
@section('LHS')
    <div class="d-none d-sm-block pt-1">
        @include('widgets.products')
    </div>
@endsection
@section('main')
    <div class="pt-1">
        <div class="card">
            <div class="card-header">
                <h5>Add New Category</h5>
            </div>
            <div class="card-body">
                <form action="{{route('categories.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <h6>Shop: {{Auth::user()->shop->name}}</h6>
                        <input type="hidden" name="shop" value="{{Auth::user()->shop->id}}">
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="category name">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" placeholder="category description"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <input class="btn btn-success" type="submit" value="Add Category">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('RHS')
    <div class="pt-1">
        @include('widgets.categories')
    </div>
@endsection

@extends('layouts.appLHSfixedRHSfixed')
@section('LHS')
    <div class="d-none d-sm-block pt-1">
        @include('widgets.products')
    </div>
@endsection
@section('main')
    <div class="pt-1">
        <div class="card">
            <div class="card-header theme-secondary-bg">
                <h5>Add New Category</h5>
            </div>
            <div class="card-body">
                @include('forms.new-category')
            </div>
        </div>
    </div>
@endsection

@section('RHS')
    <div class="pt-1">
        @include('widgets.categories')
    </div>
@endsection

@extends('layouts.appLHSfixedRHSfixed')
@section('LHS')
    @include('widgets.products')
@endsection
@section('main')
    <div style="margin-top: 5px">
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
    <div style="margin-top: 5px">
        @include('widgets.categories')
    </div>
@endsection

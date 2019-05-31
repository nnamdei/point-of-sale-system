@extends('layouts.appRHSfixed')

@section('main')

<div class="bg-white p-2 mb-1">
    <div class="d-md-flex">
        <div class="">
            <h5>Products</h5>
        </div>
        <div class="ml-auto">
            @include('product.widgets.sortable-search')
        </div>
    </div>
</div>
    
    <div style="overflow: auto">
        @include('widgets.products-grid', ['grid_layout' => ['xs'=>2, 'sm'=>3, 'md'=> 4]])
    </div>
@endsection

@section('RHS')
    <div class="mt-1">
        @include('widgets.categories')
    </div>

@endsection


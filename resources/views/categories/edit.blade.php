@extends('layouts.appRHSfixed')
@section('main')
<div class="pt-1">
    <div class="row justify-content-center">
        <div class="col-md-6 col-no-padding-xs">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Category: {{$category->name}}</h5>
                </div>
                <div class="card-body">
                    @include('forms.edit-category')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('RHS')
    <?php
    $products_w_title = "Products in $category->name";
    $products_w = $category->products;
    ?>
    <div class="pt-1">
        @include('widgets.products')
    </div>
@endsection

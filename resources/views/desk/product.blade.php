@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="lhs-fixed-head white text-center">
        <div class="theme-bg py-1" >
            <h5><i class="fa fa-cart-plus"></i> Add {{$product->name}} to cart</h5>
        </div>
    </div>
    <div class="lhs-body">
        <div class="py-3 px-2 bg-white">
            <?php $item = $product->inCart() ?>
            @if($item)
                <div class="alert alert-info text-center">
                    <i class="fa fa-cart-arrow-down"></i> {{$item->qty}} already in cart
                </div>
                @include('cart.widgets.update')
            @else
                @include('cart.widgets.add')
            @endif
        </div>
    </div>
@endsection

@section('main')
    <div class="content-fixed-head products-accordion">
        <div class="white-bg" style="padding: 5px">
            <div class="row">
                <div class="col-6 text-left">
                    <h3>{{$product->name}}</h3>
                </div>
                <div class="col-3">
                    <div style="font-size: 30px">
                        <h2>&#8358;{{number_format($product->selling_price)}}</h2>
                    </div>
                </div>
                <div class="col-3">
                    Items Available: {{number_format($product->remaining())}} 
                </div>
            </div>
        </div>
    </div>

    <div class="content-body" style="padding-top: 70px">   
         @include('products.widgets.basics')
        @include('products.widgets.statistics')
    </div>

@endsection


@section('RHS')
    <?php
        $products_w_title = "Also in ".$product->category->name;
        $products_w = $_product::where('category_id',$product->category->id)->get();
    ?>
    <div style="padding-top: 10px"> 
        @include('widgets.products')
    </div>
@endsection

@section('styles')
<style>

</style>
  
@endsection


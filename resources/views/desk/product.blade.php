@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="lhs-fixed-head text-center">
        <div class="theme-bg py-3" >
            <h6><i class="fa fa-cart-plus"></i> Add {{$product->name}} to cart</h6>
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
        <div class="bg-white" style="padding: 5px">
            <div class="row align-items-center">
                <div class="col-12 text-left">
                    <h6>{{$product->name}}</h6>
                </div>
                <div class="col-6">
                    Items Available: {{number_format($product->remaining())}} 
                </div>
                <div class="col-6">
                    <h4>&#8358;{{number_format($product->selling_price)}}</h4>
                </div>
                
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="pt-3">
            @include('product.widgets.basics')
            @include('product.widgets.statistics')
        </div>   
    </div>

@endsection


@section('RHS')
    <?php
        $products_w_title = "Also in ".$product->category_()->name;
        $products_w = $_product::where([['category_id',$product->category_()->id],['id', '!=', $product->id]])->get();
    ?>
    <div class="mt-1"> 
        @include('widgets.products')
    </div>
@endsection

@section('styles')
<style>

</style>
  
@endsection


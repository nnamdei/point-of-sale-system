@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="lhs-fixed-head white text-center">
        <div class="theme-bg" style="height; padding: 15px 10px">
            <h4> New Sale</h4>
        </div>
    </div>

    <div class="lhs-body">
        <div style="padding-top: 20px">
            @include('forms.new-sale')
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
                        <span class="badge badge-success"> &#8358;{{number_format($product->selling_price)}}</span>
                    </div>
                </div>
                <div class="col-3">
                    Items Available: <span class="badge badge-secondary">{{number_format($product->remaining())}}</span> 
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


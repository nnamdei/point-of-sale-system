@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <?php
        $products_w_title = "Also in ".$product->category->name;
        $products_w = $_product::where([['category_id',$product->category->id],['id','!=',$product->id]])->get();
    ?>
    <div class="d-none d-sm-block pt-1">
        @include('widgets.products')
    </div>
@endsection

@section('main')
    <div class="content-fixed-head products-accordion">
        <div class="white-bg" style="padding: 5px">
            <div class="row">
                <div class="col-6 text-left">
                    <strong>{{$product->name}}</strong>
                    @include('products.widgets.add-stock')
                </div>
                <div class="col-6 text-center">
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <small>Base Price</small>
                            </div>
                            <div>
                                <strong> &#8358;{{number_format($product->base_price)}}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <small>Selling Price</small>
                            </div>
                            <div>
                                <strong class="text-primary"> &#8358;{{number_format($product->selling_price)}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="content-body mt-2">   
        @include('products.widgets.basics')
        @include('products.widgets.statistics')
        <div class="card">
            <div class="card-header">
                Transaction History of {{$product->name}}
            </div>
            <div class="card-body no-padding">
                @include('transactions.widgets.filter')
                <div class="row">
                    <div class="col-12">
                        <h4>Sales</h4>
                        @include('transactions.widgets.sales')
                    </div>
                    <div class="col-12">
                        @include('transactions.widgets.activities')
                    </div>
                </div>
                
            </div>
        </div>

    </div>

@endsection


@section('RHS')
    <div class="rhs-fixed-head white text-center">
        <div class="theme-bg" style="height; padding: 15px 10px">
            <h4><i class="fa fa-eye"></i> Insights</h4>
        </div>
    </div>

    <div class="rhs-body">
        <div id="insights-container">
            @include('products.widgets.single-insights')
        </div>
    </div>
@endsection

@section('styles')
<style>

</style>
  
@endsection


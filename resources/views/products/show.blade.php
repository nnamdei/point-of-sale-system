@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="lhs-fixed-head white text-center">
        <div class="theme-bg" style="height; padding: 15px 10px">
            <h4><i class="fa fa-eye"></i> Insights</h4>
        </div>
    </div>

    <div class="lhs-body">
        <div id="insights-container">
            @include('products.widgets.single-insights')
        </div>
    </div>
@endsection

@section('main')
    <div class="content-fixed-head products-accordion">
        <div class="white-bg" style="padding: 5px">
            <div class="row">
                <div class="col-4 text-left">
                    <h5>{{$product->name}}</h5>
                    @include('products.widgets.add-stock')
                </div>
                <div class="col-5 text-center">
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <small>Base Price</small>
                            </div>
                            <div>
                                <span class="badge badge-primary"> &#8358;{{number_format($product->base_price)}}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <small>Selling Price</small>
                            </div>
                            <div>
                                <span class="badge badge-success"> &#8358;{{number_format($product->selling_price)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 text-right">
                    <div>
                        <a title="edit product {{$product->name}}" class="text-info" style="font-size: 16px" href="{{route('products.edit', ['id'  => $product->id])}}"><i class="fa fa-pen"></i> edit</a>
                        @include('products.templates.delete-btn')
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="content-body" style="padding-top: 100px">   
        @include('products.widgets.basics')
        @include('products.widgets.statistics')
        <div class="card">
            <div class="card-header">
                Transaction History of {{$product->name}}
            </div>
            <div class="card-body no-padding">
                @include('transactions.widgets.history')
            </div>
        </div>

    </div>

@endsection


@section('RHS')
    <?php
        $products_w_title = "Also in ".$product->category->name;
        $products_w = $PRODUCTS_->where('category_id',$product->category->id)->get();
    ?>
    <div style="padding-top: 5px">
        @include('widgets.products')
    </div>

@endsection

@section('styles')
<style>

</style>
  
@endsection


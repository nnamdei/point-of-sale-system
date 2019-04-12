@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')

            <div class="card" style="margin-top: 5px">
                <div class="card-header bg-white">
                    <h5>{{$shop->name}}</h5>
                    <div>
                        <small><i class="fa fa-map-marker"></i> {{$shop->address}}</small>
                    </div>
                    <div>
                        @if($shop->about !== null)
                            {{$shop->about}}
                        @endif
                    </div>
                    <small class="grey"><i class="fa fa-clock"></i> created {{$shop->created_at->diffForHumans()}}</small>
                </div>

                <div class="card-body">
                    <div class="py-1">
                        <i class="fa fa-user-tie"></i> Manager: 
                        @if($shop->hasManager())
                            <a href="{{route('staff.show',$shop->manager()->id)}}">{{$shop->manager()->fullname()}}</a>
                        @else
                            n/a
                        @endif
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex">
                                <div>
                                    <h6>Products <span class="badge badge-success">{{$shop->products->count()}}</span></h6>
                                    @if($shop->products->count() > 0)
                                        <a href="{{route('products.index').'?filter=shop&c='.$shop->name}}" class="btn btn-secondary"><i class="fa fa-box-open"></i> See Products & Insight</a>
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    <a href="{{route('products.create').'?category='.$shop->id}}">
                                        <i class="fa fa-plus" data-toggle="tooltip" title="add new product"></i>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="d-flex">
                                <div>
                                    <h6>Services <span class="badge badge-success">{{$shop->services->count()}}</span></h6>
                                </div>
                                <div class="ml-auto">
                                    <a href="{{route('service.create').'?shop='.$shop->id}}">
                                        <i class="fa fa-plus" data-toggle="tooltip" title="add new service"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>

@endsection

@section('main')
    <div class="mt-1">
        <ul class="nav nav-tabs " id="products-services-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="shop-products-tab" data-toggle="tab" href="#shop-products" role="tab" aria-controls="shop-products" aria-selected="true">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="shop-services-tab" data-toggle="tab" href="#shop-services" role="tab" aria-controls="shop-services" aria-selected="false">Services</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent" style="overflow: auto">
            <div class="tab-pane fade show active" id="shop-products" role="tabpanel" aria-labelledby="shop-products-tab">
                <?php 
                        $products_w = $shop->products;
                        $products_w_title = 'Products in '.$shop->name;
                    ?>
                    @include('widgets.products')
            </div>
            <!--Table Tab-->

            <div class="tab-pane fade" id="shop-services" role="tabpanel" aria-labelledby="shop-services-tab">
                    <?php 
                        $services_w = $shop->services;
                        $services_w_title = 'Services in '.$shop->name;
                    ?>
                    @include('widgets.services')
            </div> 
            <!-- Stock chart tab -->
        </div>
    </div>

@endsection

@section('RHS')    
    <?php
        $shops_w_title = "Other shops";
        $shops_w = $_shop::where('id','!=',$shop->id)->get();
    ?>
    <div class="mt-2">
        @include('widgets.shops')
    </div>
@endsection

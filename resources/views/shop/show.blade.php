@extends('layouts.appLHSfixedRHSfixed')
@section('styles')
<style>
    .shop-products-services .card-body{
        max-height:70vh;
        overflow: auto;
    }
</style>
@endsection
@section('LHS')
    <div class="lhs-fixed-head white text-center">
        <div class="theme-bg py-2" >
            <h5>{{$shop->name}}</h5>
            @if($shop->address != null)
                <div>
                    <i class="fa fa-map-marker"></i> {{$shop->address}}
                </div>
            @endif
        </div>
    </div>
    <div class="lhs-body">
        <div class="card pt-2">
            <div class="card-header bg-white">
                <div>
                    @if($shop->about !== null)
                        <p class="text-muted">
                        {{$shop->about}}
                        </p>
                    @endif
                </div>
                <div class="text-right">
                    <small class="text-muted"><i class="fa fa-clock"></i> created {{$shop->created_at->toDayDateTimeString()}}, {{$shop->created_at->diffForHumans()}}</small>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{route('shop.setting',[$shop->id])}}" ><i class="fa fa-cog"></i> settings</a>
                @endif
            </div>

            <div class="card-body">
                <div class="py-1">
                        Manager: 
                    @if($shop->hasManager())
                        @include('staff.templates.staff-name',['staff' => $shop->manager()])
                    @else
                        n/a
                    @endif
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div>
                                <h6>Products <span class="badge badge-secondary">{{$shop->products->count()}}</span></h6>
                                @if($shop->products->count() > 0)
                                    <a href="{{route('products.index').'?filter=shop&s='.$shop->name}}"><i class="fa fa-chart-line"></i> {{Auth::user()->isAdminOrManager() ? 'see product inventory' : 'see products'}}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                <a href="{{route('products.create').'?shop='.$shop->id}}">
                                    <i class="fa fa-plus" data-toggle="tooltip" title="add new product"></i>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="d-flex">
                            <div>
                                <h6>Services <span class="badge badge-secondary">{{$shop->services->count()}}</span></h6>
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
        @include('shop.widgets.wallet-today')
    </div>
@endsection

@section('main')
    <div class="mt-1 shop-products-services">
        @if($shop->setting->productActivated() && $shop->setting->serviceActivated())
        <ul class="nav nav-tabs " id="products-services-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{request()->get('tab') == null || request()->get('tab') == 'products' ? 'active' : ''}}" id="shop-products-tab" data-toggle="tab" href="#shop-products" role="tab" aria-controls="shop-products" aria-selected="{{request()->get('tab') == null || request()->get('tab') == 'products' ? true : 'false'}}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{request()->get('tab') == 'services' ? 'active' : ''}}" id="shop-services-tab" data-toggle="tab" href="#shop-services" role="tab" aria-controls="shop-services" aria-selected="{{request()->get('tab') == 'services' ? true : 'false'}}">Services</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent" style="overflow: auto">
            <div class="tab-pane fade {{request()->get('tab') == null || request()->get('tab') == 'products' ? 'show active' : ''}}" id="shop-products" role="tabpanel" aria-labelledby="shop-products-tab">
                    @include('widgets.products',['products_w_title' => 'Products in '.$shop->name.' ('.$shop->products->count().')', 'products_w' => $shop->products()->orderBy('created_at','desc')->paginate(20)])
            </div>
            <!--Table Tab-->

            <div class="tab-pane fade {{request()->get('tab') == 'services' ? 'show active' : ''}}" id="shop-services" role="tabpanel" aria-labelledby="shop-services-tab">
                @include('widgets.services',['services_w_title' => 'Services in '.$shop->name.' ('.$shop->services->count().')', 'services_w' => $shop->services()->orderBy('created_at','desc')->paginate(20)])
            </div> 
            <!-- Stock chart tab -->
        </div>
        @elseif($shop->setting->productActivated())
            @include('widgets.products',['products_w_title' => 'Products in '.$shop->name.' ('.$shop->products->count().')', 'products_w' => $shop->products()->orderBy('created_at','desc')->paginate(20)])
        @elseif($shop->setting->serviceActivated())
            @include('widgets.services',['services_w_title' => 'Services in '.$shop->name.' ('.$shop->services->count().')', 'services_w' => $shop->services()->orderBy('created_at','desc')->paginate(20)])
        @endif
    </div>

@endsection

@section('RHS')
    <div class="card">
        <div class="card-header">
            <h6>Receipt verification</h6>
        </div>
        <div class="card-body">
            @include('transactions.receipts.search')
        </div>
    </div>
    @include('widgets.staff',['staff_w_title' => 'Staff', 'staff_w' => $shop->staff])
@endsection

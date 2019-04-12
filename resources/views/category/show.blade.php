@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')

            <div class="card" style="margin-top: 5px">
                <div class="card-header bg-white">
                    <h5>{{$category->name}}</h5>
                    @include('category.widgets.operations')
                    
                    <div class="description-container">
                        @if($category->description !== null)
                            {{$category->description}}
                        @else
                            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description</small>
                        @endif
                    </div>
                    <small class="grey"><i class="fa fa-user"></i> created by {{$category->user->fullname()}} {{$category->created_at->diffForHumans()}}</small>
                    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
                        <br>
                        <small>last updated {{$category->updated_at->diffForHumans()}}</small>
                    @endif
                </div>
                <div class="card-body">
                    <h6>Products <span class="badge badge-success">{{$category->products()->count()}}</span></h6>
                    @if($category->products()->count() > 0)
                    <div class="text-center">
                        <a href="{{route('products.index').'?filter=category&c='.$category->name}}" class="btn btn-secondary"><i class="fa fa-box-open"></i> See Products & Insight</a>
                    </div>
                    @else
                        <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i> No product in this category yet
                        </div>
                        <a href="{{route('products.create').'?category='.$category->id}}" class="btn btn-secondary ">
                            <i class="fa fa-plus"></i> Add Product
                            </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                    <hr>
                        <h6>Other shops</h6>
                        @if(Auth::user()->otherShops()->count() > 0)
                            <ul class="list-group">
                                @foreach(Auth::user()->otherShops() as $shop)
                                    <li class="list-group-item">{{$shop->name}} - {{$shop->products()->where('category_id',$category->id)->count()}} products</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-warning text-center">
                                No other shop  <a href="{{route('shop.create')}}" class="btn btn-sm btn-success"> create shop</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            

@endsection

@section('main')
<?php
        $products_w_title = "Products in $category->name";
        $products_w = $category->products();
    ?>
    <div class="mt-2">
        @include('widgets.products')
    </div>
@endsection

@section('RHS')    
    <?php
        $categories_w_title = "Other categories";
        $categories_w = Auth::user()->shop->categories()->where('id','!=',$category->id)->orderBy('name','asc')->get();
    ?>

    <div class="mt-2">
        @include('widgets.categories')
    </div>
@endsection

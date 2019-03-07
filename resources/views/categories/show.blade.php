@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')

            <div class="card" style="margin-top: 5px">
                <div class="card-header theme-secondary-bg">
                    <h5>{{$category->name}} 
                        <div style="height: 40px; float:right">
                            <a title="edit category {{$category->name}}" class="text-info" style="font-size: 16px" href="{{route('categories.edit', ['id'  => $category->id])}}"><i class="fa fa-pen"></i> edit</a>
                            @include('categories.templates.delete-btn')
                        </div>
                    </h5>
                    
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
                    <h6>Products <span class="badge badge-success">{{$category->products->count()}}</span></h6>
                    @if($category->products->count() > 0)
                    <div class="text-center">
                        <a href="{{route('products.index').'?filter=category&c='.$category->name}}" class="btn btn-secondary btn-lg"><i class="fa fa-box-open"></i> See Products & Insight</a>
                    </div>
                    @else
                        <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i> No product in this category yet
                        </div>
                        <a href="{{route('products.create').'?category='.$category->id}}" class="btn btn-secondary btn-lg">
                            <i class="fa fa-plus"></i> Add Product
                            </a>
                    @endif
                </div>
            </div>

@endsection

@section('main')
<?php
        $products_w_title = "Products in $category->name";
        $products_w = $PRODUCTS_->where('category_id',$category->id)->get();
    ?>
    @include('widgets.products')
@endsection

@section('RHS')    
    <?php
        $categories_w_title = "Other categories";
        $categories_w = $CATEGORIES_->where('id','!=',$category->id)->get();
    ?>


    @include('widgets.categories')
@endsection

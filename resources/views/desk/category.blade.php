@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
            <div class="card" style="margin-top: 5px">
                <div class="card-header theme-secondary-bg">
                    <h5>{{$category->name}} </h5>
                    
                    <div class="description-container">
                        @if($category->description !== null)
                            {{$category->description}}
                        @else
                            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description</small>
                        @endif
                    </div>
                    <small class="grey"><i class="fa fa-user"></i> created by {{$category->user->fullname()}}, {{$category->created_at->diffForHumans()}}</small>
                    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
                        <br>
                        <small>last updated {{$category->updated_at->diffForHumans()}}</small>
                    @endif
                </div>
                <div class="card-body">
                    <h6>Products <span class="badge badge-success">{{$category->products->count()}}</span></h6>
                    @if($category->products->count() == 0)
                        <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i> No product in this category yet
                        </div>
                    @endif
                </div>
            </div>

@endsection

@section('main')
<?php
        $products_w_title = "Products in $category->name";
        $products_w = $_product::where('category_id',$category->id)->get();
    ?>
    <div  style="margin-top: 5px">
         @include('widgets.products')
    </div>
@endsection

@section('RHS')    
    <?php
        $categories_w_title = "Other categories";
        $categories_w = $_category::orderBy('name','asc')->where('id','!=',$category->id)->get();
    ?>


    @include('widgets.categories')
@endsection

@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
            <div class="card" style="margin-top: 5px">
                <div class="card-header bg-white">
                    <h5>{{$category->name}} </h5>
                </div>
                <div class="card-body">
                    <div class="py-2">
                        @if($category->description !== null)
                            {{$category->description}}
                        @else
                            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description</small>
                        @endif
                    </div>
                    <div class="my-1">
                        created {{$category->created_at->toDayDateTimeString()}}, {{$category->created_at->diffForHumans()}}
                    </div>
                    <div class="d-flex">
                        <div class="ml-auto">
                            @include('staff.templates.auth-user-name',['user' => $category->user()])
                        </div>
                    </div>
                    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
                        <div class="my-1">last updated {{$category->updated_at->diffForHumans()}}</div>
                    @endif
                    <h6>Products <span class="badge badge-success">{{$category->products()->count()}}</span></h6>
                    @if($category->products()->count() == 0)
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

<div class="mt-2">
    @include('widgets.categories')
</div>
@endsection

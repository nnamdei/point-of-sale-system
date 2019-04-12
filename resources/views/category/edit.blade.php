@extends('layouts.appRHSfixed')
@section('main')
<div class="pt-1">
    <div class="row justify-content-center">
        <div class="col-md-6 col-no-padding-xs">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Category: {{$category->name}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('categories.update',['id'=>$category->id])}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input class="form-control" type="text" name="name" value="{{$category->name}}" placeholder="category name">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" name="description" placeholder="category description">{{$category->description}}</textarea>
                        </div>
                        <div class="form-group text-center">
                            <input class="btn btn-success" type="submit" value="Update Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('RHS')
    <?php
    $products_w_title = "Products in $category->name";
    $products_w = $category->products();
    ?>
    <div class="pt-1">
        @include('widgets.products')
    </div>
@endsection

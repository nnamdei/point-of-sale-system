@extends('layouts.app')

@section('main')
    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <?php 
            $categories_w = $categories;
            $categories_w_title = 'Categories in '.Auth::user()->shop->name
             ?>
             @include('widgets.categories')
            
        </div>
    </div>
@endsection
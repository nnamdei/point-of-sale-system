@extends('layouts.app')

@section('main')
    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <?php 
            $shops_w = $shops;
            $shops_w_title = 'Shops';
             ?>
             @include('widgets.shops')
            
        </div>
    </div>
@endsection
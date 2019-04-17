@extends('layouts.app')

@section('main')
    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <?php 
            $services_w = $services;
            $services_w_title = 'Services in '.Auth::user()->shop->name
             ?>
             @include('widgets.services')
            
        </div>
    </div>
@endsection
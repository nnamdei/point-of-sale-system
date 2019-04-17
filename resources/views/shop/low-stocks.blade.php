@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-5 col-sm-8 no-padding-xs">
            @include('shop.widgets.low-stocks')
        </div>
    </div>
@endsection
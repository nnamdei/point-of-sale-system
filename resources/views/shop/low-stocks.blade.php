@extends('layouts.appLHSfixed')
@section('LHS')
    <div class="text-center bg-white p-2">
        <h6 >Products remaining <strong>{{$shop->setting->lowStock()}}</strong> or less - <strong>{{$shop->lowStockProducts()->count()}}</strong></h6>
        <div class="text-right p-2">
            <small><a href="{{route('shop.setting',[$shop->id,'tab'=>'product'])}}"><i class="fa fa-cog"></i> change setting</a></small>
        </div>
    </div>
    
@endsection
@section('main')
        <div class="mt-2">
            @if($shop->lowStockProducts()->count() > 0)
                @include('widgets.products-grid', ['products_w' =>$shop->lowStockProducts(), 'grid_layout'=> ['xs'=>2, 'sm'=> 3, 'md'=>4] ])
            @else
                <div class="p-4 text-muted text-center">
                    <i class="fa fa-check-circle theme-color"></i> No product stock running low
                </div>
            @endif
        </div>
    
@endsection
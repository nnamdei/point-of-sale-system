<div class="card">
    <div class="card-header">
        <div class="text-center theme-bg p-2">
            <h6 >Products remaining <strong>{{$shop->setting->lowStock()}}</strong> or less - <strong>{{$shop->lowStockProducts()->count()}}</strong></h6>
        </div>
        <div class="text-right p-2">
            <small><a href="{{route('shop.setting',[$shop->id,'tab'=>'product'])}}"><i class="fa fa-cog"></i> change setting</a></small>
        </div>
    </div>
    <div class="card-body">
        @if($shop->lowStockProducts()->count() > 0)
            <div class="list-group">
                @foreach($shop->lowStockProducts() as $product)
                    @include('widgets.templates.product')
                @endforeach
            </div>
        @else
            <div class="p-4 text-muted text-center">
                <i class="fa fa-check-circle theme-color"></i> No product stock running low
            </div>
        @endif
    </div>
</div>

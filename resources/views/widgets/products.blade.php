<?php
 $product_w_collection = isset($products_w) ? $products_w : Auth::user()->shop->products()->orderBy('created_at','desc')->take(10)->get();
?>
    <div class="card">
       <div class="card-header">
       <h6>{{isset($products_w_title) ? $products_w_title: 'Recent Products' }}</h6>
        @if(Auth::user()->isAdminOrManager())
            <div class="text-right">
                <a href="{{route('products.create')}}" class="btn btn-outline-secondary btn-sm" >
                    <i class="fa fa-plus-circle"></i>  Add New Product
                </a>            
            </div>
        @endif
        </div>
       <div class="card-body no-padding">
          @if($product_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($product_w_collection as $product)
                        @include('widgets.templates.product')
                    @endforeach
                </div>
            @else
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                      No product found
                </div>
            @endif
       </div>
       @if($products_w instanceof \Illuminate\Pagination\LengthAwarePaginator )
        <div class="card-footer">
            {{$products_w->links()}}
        </div>
        @endif
   </div>
  


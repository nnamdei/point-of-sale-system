<?php $product_w_collection = isset($products_w) ? $products_w : Auth::user()->shop->products()->orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
       <h5>{{isset($products_w_title) ? $products_w_title: 'Recent Products' }}</h5>
         @if(Auth::user()->isAdminOrManager())
            <div class="text-right">
                <a href="{{route('products.create')}}" class="btn btn-secondary btn-sm" >
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
                    <div class="alert alert-danger text-center" >
                        <i class="fa fa-exclamation-triangle"></i>  No product found
                    </div>
            @endif

       </div>
   </div>
  


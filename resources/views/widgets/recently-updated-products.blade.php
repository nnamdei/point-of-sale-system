<?php $product_w_collection = $_product::orderBy('updated_at','desc')->take(20)->get() ?>
    <div class="card">
       <div class="card-header">
       <h6>Recently updated products </h6>
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
   </div>
  


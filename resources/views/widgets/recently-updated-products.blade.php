<?php $product_w_collection = $_product::orderBy('updated_at','desc')->take(20)->get() ?>
    <div class="card">
       <div class="card-header">
       <strong>Recently updated products </strong>
         @if(Auth::user()->isManager())
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
                        @include('templates.product')
                    @endforeach
                </div>
            @else
                    <div class="text-center" style="padding: 10px">
                        <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No product found</small>
                    </div>
            @endif

       </div>
   </div>
  


<div class="card">
       <div class="card-header">
       <h5>{{isset($products_w_title) ? $products_w_title: 'Recent Products' }}</h5>
         @if(Auth::user()->isManager())
            <div class="text-right">
                <a href="{{route('products.create')}}" class="btn btn-secondary btn-sm" >
                    <i class="fa fa-plus-circle"></i>  Add New Product
                </a>            
            </div>
        @endif
        </div>
       <div class="card-body no-padding">
            @if(isset($products_w))
                @if($products_w->count() >0 )
                    <div class="list-group">
                        @foreach($products_w as $product)
                            @include('templates.product')
                        @endforeach
                    </div>
                @else
                    <div class="text-center" style="padding: 10px">
                        <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No product found</small>
                    </div>
                     
                @endif
            @elseif($PRODUCTS->count() > 0)
                <div class="list-group">
                    @foreach($PRODUCTS as $product)
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
  


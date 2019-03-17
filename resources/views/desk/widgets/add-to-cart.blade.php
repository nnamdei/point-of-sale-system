<div id="products-accordion-{{$product->id}}">
    @if($product->inCart())
      <div class="text-info">
          <p><i class="fa fa-cart-arrow-down"></i> {{$product->inCart()->qty}} already in the cart</small>
      </div>
      @endif

    @if($product->inCart())
      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#app-modal" data-title="Update <strong>{{$product->name}}</strong> in cart"  data-content="#product-{{$product->id}}-to-cart">
        <i class="fa fa-cart-plus"></i> Update item
      </button>
    @else
      <button class="btn btn-link text-success" data-toggle="modal" data-target="#app-modal" data-title="Add <strong>{{$product->name}}</strong> to cart"  data-content="#product-{{$product->id}}-to-cart" title="Add {{$product->name}} to cart">
        <i class="fa fa-cart-plus"></i>
      </button>
    @endif

    <div style="display: none">
      <div id="product-{{$product->id}}-to-cart">
      @if($product->inCart())
          <?php $item = $product->inCart() ?>
            @include('cart.widgets.update') 
      @else
          @include('cart.widgets.add') 
      @endif
      </div>
    </div>

</div>

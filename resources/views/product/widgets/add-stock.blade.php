    <div id="products-accordion-{{$product->id}}">
    
        <button class="btn theme-btn btn-sm" data-toggle="modal" data-target="#app-modal" data-title="Update <strong>{{$product->name}}</strong> stocks" data-content="#product-{{$product->id}}-new-stock">
            <i class="fa fa-upload"></i>  Update Stock
        </button>

        <div style="display: none">
          <div id="product-{{$product->id}}-new-stock">
                @include('product.widgets.new-stock') 
          </div>
        </div>

    </div>

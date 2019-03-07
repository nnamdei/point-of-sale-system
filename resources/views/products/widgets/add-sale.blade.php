<div id="products-accordion-{{$product->id}}">
    
    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#app-modal" data-title="<strong>{{$product->name}}</strong> Sale" data-content="#product-{{$product->id}}-new-sale">
        <i class="fa fa-upload"></i>  New Sale
    </button>

    <div style="display: none">
      <div id="product-{{$product->id}}-new-sale">
            @include('forms.new-sale') 
      </div>
    </div>

</div>

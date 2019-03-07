<span class="text-danger operations" data-toggle="tooltip" data-placement="bottom" title="trash {{$product->name}}" class="text-danger" style="cursor: pointer" onclick="javascript: confirmDelete(this,'discard-product-{{$product->id}}-confirmation')"><i class="fa fa-trash"></i> </span>            
    <div class="confirmation-container" id="discard-product-{{$product->id}}-confirmation">
        <p class="text-warning">Are you sure you want to trash product <strong>{{$product->name}} ???!</strong></p>
        <button class="btn btn-primary confirm-no">No</button>
        <button class="btn btn-danger confirm-yes">Yes,  discard</button>
        <form action="{{route('products.destroy',['id' => $product->id])}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </div>
<a class="btn btn-outline-info btn-sm m-1" title="edit product {{$product->name}}"  href="{{route('products.edit', ['id'  => $product->id])}}"><i class="fa fa-pen"></i> edit</a>
@if($product->isSimple())
    <button class="btn btn-outline-primary btn-sm m-1" data-toggle="collapse" data-target="#covert-{{$product->id}}-to-variable"><i class="fa fa-sync"></i> convert to variable</button>
@elseif($product->isVariable())
    <button class="btn btn-outline-primary btn-sm m-1" data-toggle="collapse" data-target="#covert-{{$product->id}}-to-simple"><i class="fa fa-sync"></i> convert to simple</button>
@endif
<button class="btn btn-outline-secondary btn-sm m-1" data-toggle="collapse" data-target="#reset-product-{{$product->id}}-collapse" title="reset {{$product->name}}"><i class="fa fa-undo"></i> Reset</button>            
<button class="btn btn-outline-danger btn-sm m-1" data-toggle="collapse" data-target="#discard-product-{{$product->id}}-collapse" title="trash {{$product->name}}"><i class="fa fa-times"></i> Delete</button>            

<div class="mt-1">
    @if($product->isSimple())
    <div class="collapse alert alert-info mt-1" id="covert-{{$product->id}}-to-variable" data-parent="body">
        <form class="d-inline" action="{{route('product.to.variable',[$product->id])}}" method="POST">
            @csrf
            @method('PUT')
            <p> 
                <i class="fa fa-exclamation-triangle"></i> converting <strong>{{$product->name}}</strong> to variable will reset the stocks and sales so you can appropriately distribute them to their respective variants. 
            </p>
            <button type="button" class="btn btn-danger btn-sm m-1" data-toggle="collapse" data-target="#covert-{{$product->id}}-to-variable"> <i class="fa fa-times"></i> Never mind</button>
            <button type="submit" class="btn btn-success btn-sm m-1"> <i class="fa fa-check"></i> ok, convert</button>
        </form>
    </div>
    @elseif($product->isVariable())
        <div class="collapse alert alert-info mt-1" id="covert-{{$product->id}}-to-simple" data-parent="body">
            <form action="{{route('product.to.simple',[$product->id])}}" method="POST">
                @csrf
                @method('PUT')
                <p> 
                    <i class="fa fa-exclamation-triangle"></i> converting <strong>{{$product->name}}</strong> to simple will delete the variants. 
                    Don't worry total stocks of <strong>{{$product->stocks()}}</strong> and sales of <strong>{{$product->sales()}}</strong> will still be intact! <i class="fa fa-smile"></i>
                </p>

                <button type="button" class="btn btn-danger btn-sm m-1" data-toggle="collapse" data-target="#covert-{{$product->id}}-to-simple"> <i class="fa fa-times"></i> Never mind</button>
                <button type="submit" class="btn btn-success btn-sm m-1"> <i class="fa fa-check"></i> ok, convert</button>
            </form>
        </div>
    @endif
    <div class="collapse alert alert-info" id="reset-product-{{$product->id}}-collapse" data-parent="body">
        <p>All {{$product->isVariable() ? 'variants will be deleted and ' : ''}}stocks and sales will be reset to zero.</p>
        <form action="{{route('product.reset',['id' => $product->id])}}" method="POST">
            @csrf
            @method('PUT')
            <button class="btn btn-danger btn-sm m-1" type="button" data-toggle="collapse" data-target="#reset-product-{{$product->id}}-collapse"> <i class="fa fa-times"></i> Never mind</button>
            <button class="btn btn-success btn-sm m-1"> <i class="fa fa-check"></i> ok, reset</button>
        </form>
    </div>

    <div class="collapse alert alert-danger" id="discard-product-{{$product->id}}-collapse" data-parent="body">
        <p>Are you sure you want to delete this product <strong>{{$product->name}} ???!</strong></p>
        <form action="{{route('products.destroy',['id' => $product->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="collapse" data-target="#discard-product-{{$product->id}}-collapse" > <i class="fa fa-times"></i> No, I'll keep it</button>
            <button class="btn btn-secondary btn-sm m-1" type="button" data-toggle="collapse" data-target="#reset-product-{{$product->id}}-collapse" > <i class="fa fa-undo"></i> Reset instead</button>
            <button class="btn btn-danger btn-sm m-1"> <i class="fa fa-trash"></i> Yes,  delete</button>
        </form>
    </div>
</div>

@if($product->isVariable() && $product->variants->count() === 0)
    <div class="alert alert-warning" >
        <p><i class="fa fa-exclamation-triangle animated flash infinite" style="animation-duration: 2s"></i> No variable is attached to <strong>{{$product->name}}</strong> yet.</p>
    </div>
    @include('variant.widgets.new-variant')

@endif



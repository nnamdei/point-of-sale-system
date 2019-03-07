<div id="add-variant-to-product-{{$product->id}}">
    <a class="btn btn-success btn-sm" href="#new-variables-for-product-{{$product->id}}" data-toggle="collapse" data-target="#new-variables-for-product-{{$product->id}}" aria-expanded="false" aria-controls="#new-variables-for-product-{{$product->id}}" ><i class="fa fa-plus-circle"></i> Add Variable</a>
    <div class="collapse" id="new-variables-for-product-{{$product->id}}" data-parent="#add-variant-to-product-{{$product->id}}">
        <form action="{{route('variables.add',['id' => $product->id])}}" method="POST">
            {{csrf_field()}}
            @include('forms.templates.add-variants')
            <div class="form-group text-center">
                <input type="submit" class="btn btn-secondary" value="Add Variable">
            </div>
        </form>
    </div>
</div>

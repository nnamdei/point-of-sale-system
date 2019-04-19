<a href="#" class="btn btn-outline-danger btn-sm" data-toggle="collapse" data-target="#delete-variant-{{$variant->id}}">
    <span data-toggle="tooltip" data-placement="bottom" title="remove variable {{$variant->variable}} from {{$variant->product->name}}" ><i class="fa fa-trash"></i>  remove</span>            
</a>
<div class="collapse p-2" id="delete-variant-{{$variant->id}}" data-parent="body">
    <p class="text-danger">Are you sure you want to remove <strong>{{$variant->variable}}</strong> from <strong>{{$variant->product->name}}</strong>? The stocks and sales will be removed as well</p>
    <form action="{{route('variants.destroy',['id' => $variant->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#delete-variant-{{$variant->id}}">No</button>
        <button type="submit" class="btn btn-sm btn-danger">Yes,  remove</button>
    </form>
</div>

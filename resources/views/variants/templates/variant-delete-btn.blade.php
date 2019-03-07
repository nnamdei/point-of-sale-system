<span class="text-danger operations" data-toggle="tooltip" data-placement="bottom" title="remove variable {{$variant->variable}} from {{$variant->product->name}}" class="text-danger" style="cursor: pointer" onclick="javascript: confirmDelete(this,'discard-variable-{{$variant->id}}-confirmation')"><i class="fa fa-trash"></i>  remove</span>            
    <div class="confirmation-container" id="discard-variable-{{$variant->id}}-confirmation">
        <p class="text-warning">Are you sure you want to remove <strong>{{$variant->variable}}</strong> from <strong>{{$variant->product->name}}</strong>? The stocks and sales will be removed as well</p>
        <button class="btn btn-primary confirm-no">No</button>
        <button class="btn btn-danger confirm-yes">Yes,  remove</button>
        <form action="{{route('variants.destroy',['id' => $variant->id])}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </div>

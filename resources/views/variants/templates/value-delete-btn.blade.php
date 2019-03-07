<span class="text-danger operations" data-toggle="tooltip" data-placement="bottom" title="remove  {{$value}} from {{$variant->variable}}" class="text-danger" style="cursor: pointer" onclick="javascript: confirmDelete(this,'discard-value-{{$value}}-confirmation')"><i class="fa fa-trash"></i></span>            
    <div class="confirmation-container" id="discard-value-{{$value}}-confirmation">
        <p class="text-warning">Are you sure you want to remove <strong>{{$variant->variable}} {{$value}}</strong>? The stocks and sales will be removed from <strong>{{$variant->product->name}}</strong> as well</p>
        <button class="btn btn-primary confirm-no">No</button>
        <button class="btn btn-danger confirm-yes">Yes,  remove</button>
        <?php $index = array_search($value, $variant->values()) ?>
        <form action="{{route('remove.value',['variant_id' => $variant->id,'value_index' => $index])}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </div>


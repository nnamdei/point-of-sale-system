<a href="#delete-{{$variant->id}}-{{$value}}" data-toggle="collapse" data-target="#delete-{{$variant->id}}-{{$value}}" style="margin: 5px; line-height: 30px; background-color: #f7f7f7; border-radius: 3px; padding: 5px 10px">
    <span class="text-danger" data-toggle="tooltip" data-placement="bottom" title="remove  {{$value}} from {{$variant->variable}}"><i class="fa fa-trash"></i> {{$value}}</span>            
</a>
<div class="collapse p-2" id="delete-{{$variant->id}}-{{$value}}" data-parent="body">
    <p class="text-danger">Are you sure you want to remove <strong>{{$variant->variable}} {{$value}}</strong>? The stocks and sales will be removed from <strong>{{$variant->product->name}}</strong> as well</p>
    <?php $index = array_search($value, $variant->values()) ?>
    <form action="{{route('remove.value',['variant_id' => $variant->id,'value_index' => $index])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#delete-{{$variant->id}}-{{$value}}">No</button>
        <button type="submit" class="btn btn-sm btn-danger">Yes, remove all {{$variant->variable.' '.$value}}</button>
    </form>
</div>


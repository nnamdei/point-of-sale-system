<form action="{{route('cart.update',[$item->rowId])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{$item->rowId}}" >
    <div class="d-flex justify-content-center">
     @if($item->model->isSimple())
        <div>
            <label for="">Quantity</label>
            <input type="number" name="quantity" class="form-control unsigned-quantity" onchange="javascript: checkQty(this)" value="{{$item->qty}}"  style="width: 150px; border-radius: 3px 0px 0px 3px" required>
        </div>
        @elseif($item->model->isVariable())
            @if($item->model->variants->count() > 0)
                    @foreach($item->model->variants as $variant)
                        <input type="hidden" name="v_id" value="{{$variant->id}}">
                        <div>
                            <label for="" class="label-control">change {{$variant->variable}}</label>
                            <select name="{{$variant->variable}}" id="" class="form-control" style="width: 100px; border-radius: 0px">
                                @foreach($variant->values() as $value)
                                    <option value="{{$value}}" {{$item->options[$variant->variable] == $value ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="" class="label-control">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="{{$item->qty}}" style="width: 100px; border-radius:0px" required>
                        </div>
                    @endforeach
            @endif
        @endif
        <div>
            <label for="">`</label>
            <div>
                <button type="submit" class="btn btn-success" style="border-radius: 0px 3px 3px 0px"><i class="fa fa-sync"></i> update cart</button>
            </div>
        </div>
    </div>
</form>
@include('cart.widgets.remove')
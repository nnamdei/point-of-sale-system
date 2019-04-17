<form action="{{route('cart.update',[$item->rowId])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="product_id" value="{{$item->id}}">
    <input type="hidden" name="row_id" value="{{$item->rowId}}" >
     @if($item->model->isSimple())
        <div class="d-flex">
            <div>
                <label for="">Quantity</label>
                <input type="number" name="quantity" class="form-control unsigned-quantity" onchange="javascript: checkQty(this)" value="{{$item->qty}}"  style="width: 150px; border-radius: 3px 0px 0px 3px" required>
            </div>
            <div>
                <label for="">`</label>
                <button type="submit" class="btn theme-btn btn-block" style="border-radius: 0px 3px 3px 0px"><i class="fa fa-sync"></i> update cart</button>
            </div>
        </div>
        @elseif($item->model->isVariable())
            @if($item->model->variants->count() > 0)
                    @foreach($item->model->variants as $variant)
                        <div class="variables-container">
                            <input type="hidden" name="v_id" value="{{$variant->id}}">
                            @if(isset($item->options[$variant->variable]))
                                @foreach($item->options[$variant->variable] as $key => $value)
                                    <div id="{{$variant->variable.'_'.$key.'_'.$value}}">
                                        <div class="single-variant">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label for="" class="label-control">Update {{$variant->variable}}</label>
                                                        <select name="{{$variant->variable}}[]" id="" class="form-control">
                                                            @foreach($variant->values() as $_value)
                                                                <option value="{{$_value}}" {{$key == $_value ? 'selected' : ''}}>{{$_value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="" class="label-control">Quantity</label>
                                                        <input type="number" name="qty[]" value="{{$item->options[$variant->variable][$key]}}" class="form-control" onchange="javascript: checkQty(this)" placeholder="quantity..." required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!$loop->first)
                                            <div class="text-right text-danger">
                                                <small style="cursor: pointer" onclick="javascript: document.querySelector('#{{$variant->variable.'_'.$key.'_'.$value}}').remove()" ><i class="fa fa-times"></i> remove this {{$value.' '.$variant->variable.' '.$key}} </small>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-right mt-2">
                            <button class="btn btn-sm btn-outline-secondary" role="button" onclick="javascript: duplicate('.single-variant','.variables-container')"><i class="fa fa-plus-circle" ></i> Add another {{$variant->variable}}</button>
                        </div>

                    @endforeach
            @endif
            <div>
                <button type="submit" class="btn theme-btn"><i class="fa fa-sync"></i> update cart</button>
            </div>
        @endif
</form>
@include('cart.widgets.remove')
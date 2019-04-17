@if(!$product->finished())
    @if($product->sellingPriceSet())
        <form action="{{route('cart.add')}}" method="POST" style="text-align: left">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            @if($product->isSimple())
                <div style="padding: 10px">
                    <div class="inputs-container">
                        <div class="form-group">
                            <label for="" class="label-control">Quantity</label>
                            <input class="form-control  unsigned-quantity" type="number" name="quantity" onchange="javascript: checkQty(this)" placeholder="quantity..." required>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn theme-btn" ><i class="fa fa-cart-plus"></i> Add to cart</button>
                </div>

            @elseif($product->isVariable())
                @if($product->variants->count() > 0)
                    <div class="inputs-container">
                        @foreach($product->variants as $variant)
                            <input type="hidden" name="v_id" value="{{$variant->id}}">
                            <div class="variables-container">
                                <div class="single-variant">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="" class="label-control">Select {{$variant->variable}}</label>
                                                <select name="{{$variant->variable}}[]" id="" class="form-control">
                                                    @foreach($variant->values() as $value)
                                                        <option value="{{$value}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="" class="label-control">Quantity</label>
                                                <input type="number" name="qty[]" class="form-control" onchange="javascript: checkQty(this)" placeholder="quantity..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-2">
                                <button class="btn btn-sm btn-secondary" onclick="javascript: duplicate('.single-variant','.variables-container')"><i class="fa fa-plus-circle" ></i> Add another {{$variant->variable}}</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn theme-btn" ><i class="fa fa-cart-plus"></i> Add to cart</button>
                    </div>
                @else
                    <div class="p-2 text-center text-muted">
                        <h1><i class="fa fa-exclamation-triangle animated flash infinite"></i></h1>
                        <p>This product is a variable product and no variant has been added yet, contact the manager.</p>
                    </div>
                @endif
            @endif
        </form>
    @else
        <div class="p-2 text-center text-muted">
            <h1><i class="fa fa-info-circle animated flash infinite slow"></i></h1>
            <h4>Cannot add to cart</h4>
            <p>selling price has not been added to <strong>{{$product->name}}</strong> yet. Contact the manager to attach price first</p>
        </div>
    @endif
@else
    <div class="p-2 text-center text-muted">
        <h1><i class="fa fa-exclamation-triangle animated flash infinite slow"></i></h1>
        <h4>Cannot add to cart</h4>
        <p>There is no stock for <strong>{{$product->name}}</strong></p>
    </div>
@endif

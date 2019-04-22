<div>
    <h6 class="text-center">Add Stock to <span class="theme-color">{{$product->name}}</span></h6>
    <form action="{{route('stock',['id' => $product->id])}}" method="POST" style="text-align: left">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
            @if($product->isSimple())
                <div style="padding: 10px">
                    <div class="inputs-container">
                        <div class="form-group">
                            <label for="" class="label-control">Quantity</label>
                            <div class="text-center text-muted">
                                <h6><i class="fa fa-info-circle"></i> Input negative value to remove stocks</h6>
                            </div>

                            <input class="form-control" type="number" name="quantity" placeholder="quantity to add" required>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input class="btn theme-btn" type="submit" value="Add Stock">
                    </div>
                </div>
            @elseif($product->isVariable())
                
                @if($product->variants->count() > 0)
                    <div class="inputs-container">
                        @foreach($product->variants as $variant)
                            <h5 class="text-center theme-bg py-2">{{$variant->variable}}</h5>
                            <div class="text-center text-muted">
                                <h6><i class="fa fa-info-circle"></i> Input 0 where no stock is been added to any {{$variant->variable}}, or negative value to remove stock</h6>
                            </div>
                            <input type="hidden" name="v_id" value="{{$variant->id}}">
                            @foreach($variant->values() as $value)
                            <div style="padding: 10px; background-color: {{($loop->index % 2) == 0 ? ' #f5f8fa' : '#fff' }}">
                                    <div class="form-group">
                                        <small>{{$value}}:</small>
                                        <input class="form-control" type="number" name="{{$variant->variable.'_'.$value}}" placeholder="quantity of {{$variant->variable.' '.$value}}" onchange="" required>
                                    </div>
                            </div>
                                
                            @endforeach
                        @endforeach
                    </div>
                    <div class="form-group text-center">
                        <input class="btn theme-btn" type="submit" value="Add Stocks">
                    </div>
                @endif
            @endif
    </form>

    @if($product->isVariable() && $product->variants->count() == 0)
        <?php $target = "add-variable-to-product-".$product->id."-form".rand(10000,99999) //This is to avoid conflict in the app accordion?>
        @include('product.templates.no-variables')
    @endif
    
</div>


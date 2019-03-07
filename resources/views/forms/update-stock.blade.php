<div id="product-{{$product->id}}-update-accordion" > 
    <div class="stock-update-forms-container">
        <div style="text-align: center">   
            <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#product-{{$product->id}}-add-stock" aria-expanded="false" aria-controls="#product-{{$product->id}}-add-stock">
                <i class="fa fa-download"></i> New Stocks
            </button>
            <button class="btn btn-success  btn-sm" data-toggle="collapse" data-target="#product-{{$product->id}}-add-sale" aria-expanded="false" aria-controls="#product-{{$product->id}}-remove-stock">
                <i class="fa fa-upload"></i> Add Sales
            </button>
        </div>

        <div class="collapse" id="product-{{$product->id}}-add-stock"  data-parent="#app-accordion" >
            <h6 class="text-primary text-center">Add Stock</h6>
            <form action="{{route('stock',['id' => $product->id])}}" method="POST" style="text-align: left">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="operation" value="+">
                    @if($product->isSimple())
                        <div style="padding: 10px">
                            <div class="inputs-container">
                                <div class="form-group">
                                    <input class="form-control" type="number" name="quantity" placeholder="quantity to add">
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <input class="btn btn-primary" type="submit" value="Add Stock">
                            </div>
                        </div>
                    @elseif($product->isVariable())
                        @if($product->variants->count() > 0)
                            <div class="inputs-container">
                                @foreach($product->variants as $variant)
                                    <h5 class="text-center" style="background-color: #24292E; color: #fff; padding: 10px 5px; margin-bottom: 0">{{$variant->variable}}</h5>
                                    <input type="hidden" name="v_id[]" value="{{$variant->id}}">
                                    
                                    @foreach($variant->values() as $value)
                                    <div style="padding: 10px; background-color: {{($loop->index % 2) == 0 ? ' #f5f8fa' : '#fff' }}">
                                        
                                            <div class="form-group">
                                                <small>{{$value}}:</small>
                                                <input type="hidden" name="{{$variant->variable.'_values'}}[]" value="{{$value}}">
                                                <input class="form-control" type="number" name="{{$variant->variable.'_stocks'}}[]" placeholder="quantity of {{$variant->variable.' '.$value}}">
                                            </div>
                                    
                                        
                                    </div>
                                        
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="form-group text-center">
                                <input class="btn btn-primary btn-sm" type="submit" value="Update Stocks">
                            </div>
                        @endif
                    @endif
                    
            </form>
            @if($product->isVariable() && $product->variants->count() == 0)
                <?php $target = "add-variable-to-product-".$product->id."-form".rand(10000,99999) //This is to avoid conflict in the app accordion?>
                @include('products.templates.no-variables')
            @endif
           
        </div>


        <div class="collapse" id="product-{{$product->id}}-add-sale"  data-parent="#app-accordion">
            <h6 class="text-success text-center">Add Sale</h6>
            <form action="{{route('stock',['id' => $product->id])}}" method="POST" style="text-align: left">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="operation" value="-">
                @if($product->isSimple())
                
                    <div style="padding: 10px">
                        <div class="inputs-container">
                            <div class="form-group">
                                <input class="form-control" type="number" name="quantity" placeholder="quantity sold">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <input class="btn btn-success" type="submit" value="Add Sales">
                        </div>
                    </div>
                @elseif($product->isVariable())
                    @if($product->variants->count() > 0)
                        <div class="inputs-container">
                            @foreach($product->variants as $variant)
                                <h5 class="text-center" style="background-color: #24292E; color: #fff; padding: 10px 5px; margin-bottom: 0">{{$variant->variable}}</h5>
                                <input type="hidden" name="v_id[]" value="{{$variant->id}}">
                                @foreach($variant->values() as $value)
                                <div style="padding: 10px; background-color: {{($loop->index % 2) == 0 ? ' #f5f8fa' : '#fff' }}">
                                    <div class="form-group">
                                    <small>{{$value}}:</small>
                                        <input type="hidden" name="{{$variant->variable.'_values'}}[]" value="{{$value}}">
                                        <input class="form-control" type="number" name="{{$variant->variable.'_stocks'}}[]" placeholder="quantity of {{$variant->variable.' '.$value}} sold">
                                    </div>
                                </div>
                                    
                                @endforeach
                            @endforeach
                        </div>
                        <div class="form-group text-center">
                            <input class="btn btn-success" type="submit" value="Add Sales">
                        </div>
                    @endif
                @endif
            </form>

            @if($product->isVariable() && $product->variants->count() == 0)
                <?php $target = "add-variable-to-product-".$product->id."-form".rand(10000,99999) //This is to avoid conflict in the app accordion?>
                @include('products.templates.no-variables')
            @endif
        </div>

    </div>

</div> 
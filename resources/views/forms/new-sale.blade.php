        <div>
            <h4 class="text-center">New Sale For <span class="theme-color">{{$product->name}}</span></h4>
            <h1 class="text-center "> <span class="badge badge-success">&#8358;{{number_format($product->selling_price)}}</span></h1>
            <form action="{{route('desk.sale',[$product->id])}}" method="POST" style="text-align: left">
                
                {{csrf_field()}}
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="_method" value="PUT">

                @if($product->isSimple())
                    <div style="padding: 10px">
                        <div class="inputs-container">
                            <div class="form-group">
                                <label for="" class="lebal-control">Quantity</label>
                                <input class="form-control" type="number" name="quantity" placeholder="quantity...">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <input class="btn theme-btn" type="submit" value="Add to Cart">
                        </div>
                    </div>
                @elseif($product->isVariable())
                    @if($product->variants->count() > 0)
                        <div class="inputs-container">
                            @foreach($product->variants as $variant)
                            <input type="hidden" name="v_id" value="{{$variant->id}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="" class="label-control">Select {{$variant->variable}}</label>
                                        <select name="variable" id="" class="form-control">
                                            @foreach($variant->values() as $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="" class="label-control">Quantity</label>
                                        <input type="number" name="quantity" class="form-control">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group text-center">
                            <input class="btn btn-success" type="submit" value="Submit">
                        </div>
                    @endif
                @endif
            </form>
        </div>
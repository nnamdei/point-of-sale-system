<div class="nav-item dropdown" >
    <a class="nav-link dropdown-toggle" href="#" id="nav-bar-cart-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 15px" >
    <sup class="badge badge-secondary">{{Cart::count()}}</sup><i class="fa fa-shopping-cart theme-color"></i> &#8358; {{Cart::total()}} 
    </a>
    <div class="dropdown-menu pt-0" aria-labelledby="nav-bar-cart-dropdown" style="min-width: 250px">
        @if(Cart::count() > 0)
            <h5 class="text-center theme-bg p-2">Cart Items</h5>
            <div class="list-group" style="max-height: 70vh; overflow: auto">
                @foreach(Cart::content() as $item)
                <div class="list-group-item border-0">
                    <img src="{{$item->model->preview()}}" alt="" style="width: 100%">
                    <div>
                        <a href="{{route('desk.product',[$item->model->id])}}">{{$item->name}}</a>
                        <div class="d-flex justify-content-center align-items-start" style="font-size: 12px">
                            <div class="m-auto"> Price: <br> &#8358; {{number_format($item->model->selling_price)}}</div>
                            <div class="m-auto">
                                Qty: {{number_format($item->qty)}}
                                <br>
                                @if(count($item->options) > 0)
                                        @foreach($item->options as $variant => $variable)
                                        <div>
                                            {{$variant}} : 
                                            @foreach($variable as $value => $qty)
                                                {{$value}}({{$qty}})
                                                <br>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    @endif
                            </div>
                            <div class="m-auto">Total: <br> &#8358; {{number_format($item->total)}}</div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <div>
                                <small><a href="{{route('desk.product',[$item->model->id])}}"><i class="fa fa-sync"></i> update item</a></small>
                            </div>
                            <div class="ml-auto"> @include('cart.widgets.remove')</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @endforeach
            </div>
            <div class="d-flex p-2">
                <small class="mr-auto"><a href="{{route('cart.empty')}}" class="text-danger"><i class="fa fa-ban"></i> empty cart</a></small>
                <small><a href="{{route('desk.cart')}}"><i class="fa fa-sign-out-alt"></i> Checkout</a></small>
            </div>
        @else
            <div class="text-center">
                <small class="text-danger"><i class="fa fa-shopping-cart"></i> cart empty</small>
            </div>
        @endif
    </div>
</div>
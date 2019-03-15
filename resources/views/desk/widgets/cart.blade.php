<div class="nav-item dropdown" >
    <a class="nav-link dropdown-toggle" href="#" id="nav-bar-cart-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 20px" >
    <sup class="badge badge-success">{{Cart::count()}}</sup><i class="fa fa-shopping-cart"></i> &#8358; {{Cart::total()}} 
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
                        <div class="d-flex justify-content-center" style="font-size: 12px">
                            <span class="m-auto"> Price: {{$item->model->selling_price}}</span>
                            <span class="m-auto">Qty: {{$item->qty}}</span>
                            <span class="m-auto">Total: {{$item->total}}</span>
                        </div>
                        <div class="text-right"> @include('cart.widgets.remove')</div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @endforeach
            </div>
            <div class="d-flex p-2">
                <small class="mr-auto"><a href="{{route('cart.empty')}}" class="text-danger"><i class="fa fa-ban"></i> clear cart</a></small>
                <small><a href="{{route('desk.cart')}}"><i class="fa fa-sign-out-alt"></i> Checkout</a></small>
            </div>
        @else
            <div class="text-center">
                <small class="text-danger"><i class="fa fa-shopping-cart"></i> cart empty</small>
            </div>
        @endif
    </div>
</div>
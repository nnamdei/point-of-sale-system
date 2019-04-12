<table class="table table-light table-bordered">
    <thead >
        <tr class="white-bg" >
            <td class="text-center " colspan="{{Auth::user()->isAdminOrManager() ? 3 : 2}}" style="border:0">
                <h5 class="theme-color"><i class="fa fa-calendar theme-color"></i> {{$period}}</h5>
            </td>
            <?php
                $totalSale = 0;
                foreach($sales as $s){
                    $totalSale += $s->price * $s->quantity;
                }
            ?>
            <td colspan="2" style="border:0"><h2><span class="" data-toggle="tooltip" title="Total sales: {{$period}}">&#8358;{{number_format($totalSale)}}</span></h2></td>
            <td class="text-center" style="border:0"><i class="fa fa-arrow-up"></i> Highest Sold: 
                @if(isset($mostSold))
                    <a href="{{Auth::user()->isAdminOrManager() ? route('products.show',['id'=>$mostSold->product()->id]) : route('desk.product',['id'=>$mostSold->product()->id])}}" data-toggle="tooltip" data-placement="top" title="{{$mostSold->total}} sold {{$period}}"> {{$mostSold->product()->name}} <span class="badge badge-primary">{{$mostSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
            </td>
            <td class="text-center" style="border:0">
                <i class="fa fa-arrow-down"></i> Least Sold:
                @if(isset($leastSold))
                    <a href="{{Auth::user()->isAdminOrManager() ? route('products.show',['id'=>$leastSold->product()->id]) : route('desk.product',['id'=>$leastSold->product()->id])}}" data-toggle="tooltip" data-placement="top" title="{{$leastSold->total}} sold {{$period}}"> {{$leastSold->product()->name}} <span class="badge badge-warning">{{$leastSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
             </td>
        </tr>
        <tr class="theme-secondary-bg">
            <td>Product</td>
            <td>Category</td>
            <td>Price sold</td>
            <td>Quantity</td>
            <td>Value</td>
            @if(Auth::user()->isAdminOrManager())
                <td>Attendant</td>
            @endif
            <td>Cart</td>
        </tr>
    </thead>
    <tbody>
    @if($sales->count() > 0)
        @foreach($sales as $sale)
            <tr class="{{$sale->product()->trashed() ? 'text-danger' : ''}}">
                 <td>
                 <img src="{{$sale->product()->preview()}}" alt="{{$sale->product()->name}}" width="100px">
                @if($sale->product()->trashed())
                    {{$sale->product()->name}}
                    <br>
                    <small class="text-danger">
                        <i class="fa fa-trash"></i> product deleted {{$sale->product()->deleted_at->toDayDateTimeString()}}
                    </small>
                @else
                    <a href="{{route('desk.product',['id'=>$sale->product()->id])}}"  data-toggle="tooltip" data-placement="top" title="{{$sale->product()->description}}">
                        {{$sale->product()->name}}
                    </a>
                    <br>
                    <small class="grey">
                        <span class="badge {{$sale->product()->stocksLow() ? 'badge-warning animated flash infinite slow' : 'badge-secondary'}}">{{$sale->product()->remaining()}}</span> remaining
                    </small>
                @endif

                </td>
                <td>{{$sale->product()->category->name}}</td>
                <td>{{number_format($sale->price)}}</td>
                <td>
                    {{$sale->quantity}}
                <?php $product = $sale->product() ?>
                    @if(Auth::user()->isAdminOrManager()  && !$sale->product()->trashed())
                    {{--@include('products.widgets.add-stock')--}}
                    @elseif(Auth::user()->isAttendant() && !$sale->product()->trashed())
                        @include('desk.widgets.add-to-cart')
                    @endif

                </td>
                <td>{{number_format($sale->price * $sale->quantity)}}</td>
                @if(Auth::user()->isAdminOrManager())
                    <td>
                        <img src="{{$sale->user->avatar()}}" alt="$sale->user->fullname()" class="avatar" width="40px" height="40px">
                        <span><a href="{{route('users.show',[$sale->user->id])}}">{{$sale->user->fullname()}}</a> </span>
                    </td>
                @endif
                <td>
                    <a href="{{route('cart.show',['ref'=>$sale->cart->identifier])}}">{{$sale->cart->identifier}}</a>
                    <p class="text-right grey" style="margin: 0">
                        <small><i class="fa fa-clock"></i> {{$sale->created_at->toDayDateTimeString()}}, {{$sale->created_at->diffForHumans()}}</small>
                    </p>

                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center"><i class="fa fa-info-circle"></i>  No Sales</td>
        </tr>
    @endif
    </tbody>
</table>

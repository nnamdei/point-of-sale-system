<table class="table table-striped table-light table-hover">
    <thead>
        <tr class="white-bg" >
            <td colspan="2" style="border-top:none">
                <h4 class="theme-secondary-color">Sales</h4>
                <h5 class="theme-color"><i class="fa fa-calendar theme-color"></i> {{$period}}</h5>
            </td>
            <?php
                $totalSale = 0;
                foreach($sales as $s){
                    $totalSale += $s->price * $s->quantity;
                }
            ?>
            <td colspan="2"><h2 data-toggle="tooltip" title="Total sales: {{$period}}"><span class="badge badge-secondary">&#8358;{{number_format($totalSale)}}</span></h2></td>
            <td><i class="fa fa-arrow-up"></i> Highest Sold: 
                @if(isset($mostSold))
                    <a href="{{Auth::user()->isManager() ? route('products.show',['id'=>$mostSold->product->id]) : route('desk.product',['id'=>$mostSold->product->id])}}" data-toggle="tooltip" data-placement="top" title="{{$mostSold->total}} sold {{$period}}"> {{$mostSold->product->name}} <span class="badge badge-primary">{{$mostSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
            </td>
            <td>
                <i class="fa fa-arrow-down"></i> Least Sold:
                @if(isset($leastSold))
                    <a href="{{Auth::user()->isManager() ? route('products.show',['id'=>$leastSold->product->id]) : route('desk.product',['id'=>$leastSold->product->id])}}" data-toggle="tooltip" data-placement="top" title="{{$leastSold->total}} sold {{$period}}"> {{$leastSold->product->name}} <span class="badge badge-warning">{{$leastSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
             </td>
        </tr>
        <tr class="theme-secondary-bg">
            <td>id</td>
            <td>Product</td>
            <td>Category</td>
            <td>Price sold</td>
            <td>Quantity</td>
            <td>Value</td>
        </tr>
    </thead>
    <tbody>
    @if($sales->count() > 0)
        @foreach($sales as $sale)
            <tr>
                <td>#{{$sale->id}}</td>
                 <td>
                 <img src="{{$sale->product->preview()}}" alt="{{$sale->product->name}}" width="100px">
                @if(Auth::user()->isManager())
                    <a href="{{route('products.show',['id'=>$sale->product->id])}}" data-toggle="tooltip" data-placement="top" title="{{$sale->product->description}}">
                        {{$sale->product->name}}
                    </a>
                @else
                    <a href="{{route('desk.product',['id'=>$sale->product->id])}}"  data-toggle="tooltip" data-placement="top" title="{{$sale->product->description}}">
                        {{$sale->product->name}}
                    </a>
                @endif
                <br>
                <small class="grey">
                    <span class="badge {{$sale->product->stocksLow() ? 'badge-warning animated flash infinite slow' : 'badge-secondary'}}">{{$sale->product->remaining()}}</span> remaining
                </small>
                </td>
                <td>{{$sale->product->category->name}}</td>
                <td>{{number_format($sale->price)}}</td>
                <td>
                    {{$sale->quantity}}
                <?php $product = $sale->product ?>
                    @if(Auth::user()->isManager())
                        @include('products.widgets.add-stock')
                    @else
                        @include('products.widgets.add-sale')
                    @endif

                </td>
                <td>{{number_format($sale->price * $sale->quantity)}}
                    <p class="text-right grey" style="margin: 0">
                        @if(Auth::user()->isManager())
                            <img src="{{$sale->user->avatar()}}" alt="$sale->user->fullname()" class="avatar" width="40px" height="40px">
                            <small>{{$sale->user->fullname()}}, </small> <br>
                        @endif
                        <small><i class="fa fa-clock"></i> {{$sale->created_at->diffForHumans()}}</small>
                    </p>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center"><i class="fa fa-info-circle"></i>  No Sales</td>
        </tr>
    @endif
    </tbody>
</table>

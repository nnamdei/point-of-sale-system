<?php
    $valid = 0;
    $valid_count = 0;
    $revoked = 0;
    $revoked_count = 0;
    foreach($sales as $s){
        if($s->trashed()){
            $revoked += $s->price * $s->quantity;
            $revoked_count++;
        }else{
            $valid += $s->price * $s->quantity;
            $valid_count++;
        }
    }
?>
<table class="table table-light table-bordered">
    <thead >
        <tr class="bg-white" >
            <td class="" colspan="{{Auth::user()->isAdminOrManager() ? 3 : 2}}" style="border:0">
                <strong class="theme-color"><i class="fa fa-calendar theme-color"></i> {{$period}}</strong>
            </td>
            <td colspan="3">
                <div>
                    <span class="theme-color"><i class="fa fa-sync"></i> Total ({{$revoked_count + $valid_count}}) - <strong data-toggle="tooltip" title="Total sales: {{$period}}">&#8358; {{number_format($valid + $revoked)}}</strong></span>
                </div>
                <div>
                   <span class="text-danger"><i class="fa fa-times"></i> Revoked ({{$revoked_count}}) -  <strong data-toggle="tooltip" title="Total revoked: {{$period}}">&#8358; {{number_format($revoked)}}</strong></span> 
                </div>
                <div>
                    <span class="text-success"><i class="fa fa-check"></i> Valid ({{$valid_count}}) -  <strong class="text-success" data-toggle="tooltip" title="Total valid: {{$period}}">&#8358; {{number_format($valid)}}</strong></span>
                </div>
            </td>
            <td class="text-center" style="border:0"><i class="fa fa-arrow-up"></i> Highest Sold: 
                @if(isset($mostSold))
                    <a href="{{route('products.show',['id'=>$mostSold->product()->id])}}" data-toggle="tooltip" data-placement="top" title="{{$mostSold->total}} sold {{$period}}"> {{$mostSold->product()->name}} <span class="badge badge-primary">{{$mostSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
            </td>
            <td class="text-center" style="border:0">
                <i class="fa fa-arrow-down"></i> Least Sold:
                @if(isset($leastSold))
                    <a href="{{route('products.show',['id'=>$leastSold->product()->id])}}" data-toggle="tooltip" data-placement="top" title="{{$leastSold->total}} sold {{$period}}"> {{$leastSold->product()->name}} <span class="badge badge-warning">{{$leastSold->total}}</span></a>
                @else
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                @endif
             </td>
        </tr>
        <tr class="theme-bg border-0">
            <td>status</td>
            <td>Product</td>
            <td>Category</td>
            <td>Price sold</td>
            <td>Quantity</td>
            <td>Value</td>
            @if(Auth::user()->isAdminOrManager())
                <td>Attendant</td>
            @endif
            <td>Receipt</td>
        </tr>
    </thead>
    <tbody>
    @if($sales->count() > 0)
        @foreach($sales as $sale)
            <tr class="{{$sale->trashed() ? 'text-danger' : ''}}">
                <td>
                    @if($sale->trashed())
                        <i class="fa fa-times text-danger" style="font-size: 30px" data-toggle="tooltip" title="revoked {{$sale->deleted_at->toDayDateTimeString()}}"></i>
                    @else
                        <i class="fa fa-check text-success" style="font-size: 30px"></i>
                    @endif
                </td>
                 <td>
                 <img class="product-preview" src="{{$sale->product()->preview()}}" alt="{{$sale->product()->name}}" width="70px" height="70px">
                @if($sale->product()->trashed())
                    <span class="text-danger" data-toggle="tooltip" title="product trashed {{$sale->product()->deleted_at->toDayDateTimeString()}}">{{$sale->product()->name}} <i class="fa fa-exclamation-triangle animated flash infinite slow"></i></span>
                @else
                    <a href="{{route('products.show',['id'=>$sale->product()->id])}}"  data-toggle="tooltip" data-placement="top" title="{{$sale->product()->description}}">
                        {{$sale->product()->name}}
                    </a>
                    <br>
                    <small class="grey">
                        <span class="badge {{$sale->product()->stocksLow() ? 'badge-warning animated flash infinite slow' : 'badge-secondary'}}">{{$sale->product()->remaining()}}</span> remaining
                    </small>
                @endif

                </td>
                <td>@include('category.templates.category-name', ['category' => $sale->product()->category_()])</td>
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
                        @include('staff.templates.auth-user-name',['user' => $sale->user()])
                    </td>
                @endif
                <td>
                    <a href="{{route('receipt.verify',['receipt' => 'sale','ref'=>$sale->cart->identifier])}}">{{$sale->cart->identifier}}</a>
                    <p class="text-right grey" style="margin: 0">
                        <small><i class="fa fa-clock"></i> {{$sale->created_at->toDayDateTimeString()}}, {{$sale->created_at->diffForHumans()}}</small>
                    </p>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8">
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                    No sale
                </div>
            </td>
        </tr>
    @endif
    </tbody>
</table>

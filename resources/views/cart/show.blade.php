@extends('layouts.appLHSfixed')

@section('LHS')
    <div class="card mt-2">
        <div class="card-header">
            <h4>Cart Summary</h4>
        </div>
        <div class="card-body bg-white">
           <table class="table">
               <tr>
                   <td>Items:</td>
                   <td>{{Cart::count()}}</td>
               </tr>
               <tr>
                   <td>Subtotal:</td>
                   <td>{{Cart::subTotal()}}</td>
               </tr>
               <tr>
                   <td>Tax:</td>
                   <td>{{Cart::tax()}}</td>
               </tr>
               <tr>
                   <td>Total:</td>
                   <td>{{Cart::total()}}</td>
               </tr>
           </table>

           <div style="display: none">
                <div id="complete-transaction">
                    @include('cart.widgets.payment') 
                </div>
            </div>

           <div class="d-flex">
                <a href="{{route('cart.empty')}}" class="btn btn-sm btn-outline-danger">
                    <i class="fa fa-ban"></i> empty cart
                </a>
                <button class="btn theme-btn btn-sm ml-auto" data-toggle="modal" data-target="#app-modal" data-title="Select method of payment" data-content="#complete-transaction">
                    <i class="fa fa-sign-out-alt"></i> Checkout
                </button>
           </div>

        </div>
    </div>
@endsection

@section('main')
    <h5>Cart</h5>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-center">Price (&#8358;)</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @if($cart->count() > 0)
                @foreach($cart as $item)
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div>
                                    <img src="{{$item->model->preview()}}" alt="" width="50px" height="50px" class="product-preview">
                                    <a href="{{route('desk.product',[$item->model->id])}}">{{$item->name}}</a> 
                                    @if(count($item->options) > 0)
                                        @foreach($item->options as $variant => $variable)
                                        <div>
                                            {{$variant}} : 
                                            @foreach($variable as $value => $qty)
                                                {{$value}}({{$qty}})
                                            @endforeach
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    @include('cart.widgets.remove')
                                </div>
                            </div>
                        </td>
                        <td class="text-center"> {{number_format($item->price)}}</td>
                        <td class="text-center">
                            {{$item->qty}}
                            <a href="#" class="ml-2" title="update quantity" data-toggle="collapse" data-target="#update-{{$item->rowId}}"><i class="fa fa-sync"></i></a>
                            <div class="collapse" id="update-{{$item->rowId}}">
                                @include('cart.widgets.update')
                            </div>
                        </td>
                        <td class="text-center">{{number_format($item->total)}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td  colspan="4" class="text-center"><small class="text-danger text-center"> <i class="fa fa-shopping-cart"></i> No product in the cart</small></td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection

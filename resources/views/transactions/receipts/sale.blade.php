@extends('layouts.appRHSfixed')


@section('main')
        @if(isset($cart))
            <div class="card shadow-lg mt-2">
                <div class="card-body">
                    <div>
                        <h5>Ref: {{$cart->identifier}}</h5>
                        <div>
                            Attendant: 
                            @include('staff.templates.auth-user-name',['user' => $cart->user()])
                        </div>
                        <div>
                            <i class="fa fa-calendar"></i> {{$cart->created_at->toDayDateTimeString()}}, {{$cart->created_at->diffForHumans()}}
                        </div>
                        <div>
                            Payment: {{$cart->payment}}
                        </div>

                    </div>
                </div>
            </div>
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($contents->count() > 0)
                        @foreach($contents as $item)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                            @if($item->model != null)
                                                <img src="{{$item->model->preview()}}" alt="" width="50px" height="50px" class="product-preview">
                                                <a href="{{route('products.show',[$item->model->id])}}">{{$item->name}}</a> 
                                            @else
                                                <div>
                                                    <span class="text-danger" data-toggle="tooltip" title="product trashed">{{$item->name}} <i class="fa fa-exclamation-triangle animated flash infinite slow"></i></span>
                                                </div>
                                            @endif
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
                                        @if($cart->sale($item->id)->trashed())
                                            <div class="ml-auto">
                                                <i class="fa fa-times text-danger" style="font-size: 30px" data-toggle="tooltip" title="sale revoked {{$cart->sale($item->id)->deleted_at->toDayDateTimeString()}}"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">&#8358; {{number_format($item->price)}}</td>
                                <td class="text-center">
                                    {{number_format($item->qty)}}
                                </td>
                                <td class="text-center">{{number_format($item->total)}}</td>
                                <td class="text-right">
                                    @if(!$cart->sale($item->id)->trashed())
                                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="collapse" data-target="#revoke-sale-{{$cart->sale($item->id)->id}}-collapse">
                                            <i class="fa fa-times" data-toggle="tooltip" title="revoke sale"></i>
                                        </button>
                                        <div class="collapse p-2" id="revoke-sale-{{$cart->sale($item->id)->id}}-collapse" data-parent="body">
                                            <form action="{{route('sale.revoke',[$cart->sale($item->id)->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="deduct_sales" name="deduct_sales" value="true">
                                                        <label class="custom-control-label" for="deduct_sales"> Deduct <strong>{{$cart->sale($item->id)->quantity}}</strong> from total sales</label>
                                                    </div>
                                                    <p class="text-muted"><i class="fa fa-info-circle"></i> By deducting <strong>{{$cart->sale($item->id)->quantity}}</strong> from total sales, <strong>{{$cart->sale($item->id)->quantity}}</strong> will also be added to total remaining</p>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-danger">Revoke sale</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td  colspan="4" class="text-center"><small class="text-danger text-center"> <i class="fa fa-shopping-cart"></i> No product found in the cart</small></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @else
            <div class="bg-white shadow-lg py-3 text-danger text-center">
                    <h1><i class="fa fa-exclamation-triangle"></i></h1>
                    <h4>No sale receipt was found with ref <i><q>{{$ref}}</q></i></h4>
                </div>
        @endif
@endsection

@section('RHS')
    @if(isset($ref))
        <div class="card mt-2">
            <div class="card-header">
                <h4>Cart Summary</h4>
            </div>
            <div class="card-body">
                @if(isset($cart))
                    <table class="table">
                        <tr>
                            <td>Products:</td>
                            <td>{{number_format($summary['products'])}}</td>
                        </tr>
                        <tr>
                            <td>Items:</td>
                            <td>{{number_format($summary['items'])}}</td>
                        </tr>
                        <tr>
                            <td>Subtotal:</td>
                            <td>{{number_format($summary['subtotal'])}}</td>
                        </tr>
                        <tr>
                            <td>Tax:</td>
                            <td>{{number_format($summary['tax'])}}</td>
                        </tr>
                        <tr>
                                <td>Total:</td>
                            <td>{{number_format($summary['total'])}}</td>
                        </tr>

                    </table>
                    <div class="text-right">
                        <a href="{{route('receipt.verify',['receipt' => 'sale', 'ref' => $ref, 'print' => 'true'])}}" class="btn btn-sm theme-btn" data-toggle="tooltip" title="print receipt"><i class="fa fa-print"></i></a>
                    </div>
            @else
                <div class="grey text-center">
                    <h1><i class="fa fa-exclamation-triangle"></i></h1>
                    <h5>No receipt found</h5>
                </div>
            @endif
            </div>
        </div>
    @endif
@endsection


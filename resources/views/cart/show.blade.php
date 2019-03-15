@extends('layouts.appRHSfixed')


@section('main')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="mt-2">
                @include('forms.search-cart')
            </div>
        </div>
    </div>
    @if(isset($ref))
        @if(isset($cart))
            <div class="card mt-2">
                <div class="card-body">
                    <div>
                        <h5>Cart: {{$cart->identifier}}</h5>
                        <div>
                            Attendant: {{$cart->attendant() == null ? '<span class="text-danger">The attendant no longer exist</span>' : $cart->attendant()->fullname()}}
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
                    </tr>
                </thead>
                <tbody>
                    @if($contents->count() > 0)
                        @foreach($contents as $item)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                            @if(!$item->model == null)
                                                <a href="{{route('desk.product',[$item->model->id])}}">{{$item->name}}</a> 
                                            @else
                                                <div>
                                                    {{$item->name}}
                                                    <br>
                                                    <small class="text-danger"><i class="fa fa-trash"></i> deleted</small>
                                                </div>
                                            @endif
                                            @if(count($item->options) > 0)
                                                @foreach($item->options as $key => $value)
                                                <div>
                                                    {{$key}} : {{$value}}
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    
                                    </div>
                                </td>
                                <td class="text-center">&#8358; {{number_format($item->price)}}</td>
                                <td class="text-center">
                                    {{number_format($item->qty)}}
                                </td>
                                <td class="text-center">{{number_format($item->total)}}</td>
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
            <div class="text-danger text-center">
                    <h1><i class="fa fa-exclamation-triangle"></i></h1>
                    <h4>No receipt was found with ref <i><q>{{$ref}}</q></i></h4>
                </div>
        @endif
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
            @else
                <div class="grey text-center">
                    <h1><i class="fa fa-exclamation-triangle"></i></h1>
                    <h4>No receipt found</h4>
                </div>
            @endif
            </div>
        </div>
    @endif
@endsection


@extends('layouts.appCenter')


                @section('header')
                    Variant {{$variant->variable}} for <a href="{{route('products.show',['id' => $variant->product->id])}}">{{$variant->product->name}}</a>
                    <div style="float:right">
                            @include('variants.templates.variant-delete-btn')
                   </div> 
                @endsection
                @section('main')

                        @if($variant->hasValues())
                            @foreach($variant->values() as $value)
                                <span style="margin: 5px; line-height: 30px; background-color: #f7f7f7; border-radius: 3px; padding: 5px 10px">
                                    @include('variants.templates.value-delete-btn')&nbsp{{$value}}
                                </span>
                            @endforeach
                       
                            @include('forms.edit-variant')
                            @else
                                <div class="text-center text-danger">
                                    <i class="fa fa-info-circle"></i> No values found for {{$variant->variable}}
                                </div>
                         @endif

               @endsection


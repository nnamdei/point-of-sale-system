@extends('layouts.appCenter')

                @section('main')

                    <div class="card mt-2">
                        <div class="card-header">
                            Variant {{$variant->variable}} for <a href="{{route('products.show',['id' => $variant->product->id])}}">{{$variant->product->name}}</a>
                            <div>
                                @include('variant.templates.variant-delete-btn')
                            </div>
                        </div>
                        <div class="card-body">
                            @if($variant->hasValues())
                                @foreach($variant->values() as $value)
                                    @include('variant.templates.value-delete-btn')

                                @endforeach
                                    <form action="{{route('variants.update',['id'=>$variant->id])}}" method="POST">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="form-group">
                                            <label for=""><strong> Rename variable</strong></label>
                                            <input class="form-control" type="text" name="variable" value="{{$variant->variable}}" placeholder="variable name (attribute)">
                                        </div>
                                                @foreach($variant->values() as $value)
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="{{$value}}" value="{{$value}}">
                                                    @include('variant.widgets.value-statistics')
                                                </div>
                                                @endforeach
                                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#new-values-collapse" aria-expanded="false" aria-controls="#new-values-collapse"><i class="fa fa-plus"></i>  Add new value for {{$variant->variable}}</button>
                                                    <div class="collapse" id="new-values-collapse" style="margin-top: 5px;">
                                                        <div id="new-value-form-groups-container">
                                                            <div class="form-group new-value-form-group">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <input type="text" name="new_values[]" class="form-control" placeholder="new value for {{$variant->variable}}">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" name="new_stocks[]" class="form-control" placeholder="add stock">
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-right">
                                                            <span onclick="javascript: duplicate('.new-value-form-group','#new-value-form-groups-container')"><i class="fa fa-plus-circle text-primary"></i>
                                                        </div>
                                                    </div>

                                        <div class="form-group text-center">
                                            <input class="btn btn-success" type="submit" value="Update Variants">
                                        </div>
                                    </form>

                                @else
                                    <div class="text-center text-danger">
                                        <i class="fa fa-info-circle"></i> No values found for {{$variant->variable}}
                                    </div>
                            @endif
                        </div>
                    </div>

               @endsection


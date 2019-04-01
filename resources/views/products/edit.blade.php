@extends('layouts.app')

@section('main')
<div class="row">
    <div class="col-md-10 offset-md-1 col-no-padding-xs">
        <div class="card" style="margin-top: 5px">
            <div class="card-header">
                Edit Product: {{$product->name}}
            </div>
            <div class="card-body">
                Product Type: <strong>{{$product->type}}</strong>
                @if($product->isVariable()) 
                    @if($product->variants->count() > 0)
                        <small> {!!$product->variables()!!}</small>
                    @else
                        @include('products.templates.no-variables')
                    @endif
                @endif
                @include('forms.edit-product')    
            </div>
        </div>

    </div>
</div>
@endsection

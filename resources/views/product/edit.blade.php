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

                <form action="{{route('products.update',['id' => $product->id])}}" method="POST" class="has-image-upload" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Product Name</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="name" placeholder="name" value="{{$product->name}}">
                                        
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            
                            <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Product Category</label>
                                    </div>
                                    <div class="col-sm-8">
                                        @if($_category::count() > 0)
                                            <select name="category" id="" class="form-control">
                                                    <option value="0">Uncategorized</option>
                                                    @foreach($_category::orderBy('name','asc')->get() as $category)
                                                        <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                            <select name="category" id="" class="form-control">
                                                <option value="0">Uncategorized</option>
                                            </select> 
                                            <br>
                                            <small class="text-warning"><i class="fa fa-info"></i>  No category yet
                                                    <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#new-category" role="button" aria-expanded="false" aria-controls="new-category">
                                                        <i class="fa fa-plus-circle"></i>  Add New Category
                                                    </a>
                                            </small>
                                            @endif
                                
                                        @if ($errors->has('category'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Description <i><small>(optional)</small></i></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" placeholder="product description">{{$product->description}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('base_price') ? ' has-error' : '' }}" >
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Base Price</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="number" name="base_price" id="base-price" value="{{$product->base_price}}" required>
                                        @if ($errors->has('stock'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('base_price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('selling_price') ? ' has-error' : '' }}" >
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Selling Price</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="number" name="selling_price" id="selling-price"  value="{{$product->selling_price}}" required>
                                        @if ($errors->has('stock'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('selling_price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img id="product-preview" src="{{$product->preview()}}" alt="{{$product->name}}" width="100%">
                                <div class="image-preview-container" replace="#product-preview"></div>
                            </div>
                            <div class="form-group">
                                <label for="preview" class="control-label grey">Preview Image (optional)</label>
                                <input type="file" name="preview" id="preview">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group text-center">
                                <input class="btn btn-success" type="submit" value="Update Product">
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

    </div>
</div>
@endsection

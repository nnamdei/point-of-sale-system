<form action="{{route('products.store')}}" method="POST" class="has-image-upload" enctype="multipart/form-data">
        {{csrf_field()}}


        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Product Name</label>
                </div>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="name" placeholder="name" value="{{old('name')}}">
                    
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
                        <select name="category" id="" class="form-control">
                                @foreach($CATEGORIES as $category)
                                    <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
               
                    @if ($errors->has('category'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>


        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Description <i><small>(optional)</small></i></label>
                </div>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description" id="" cols="30" rows="10" placeholder="product description">{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}" id="product-type-form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Product Type</label>
                </div>
                <div class="col-sm-6">
                <select name="type" id="product-type-selector" class="form-control">
                        <option value="simple" {{old('type') == 'simple' ? 'selected' : ''}}>Simple</option>
                        <option value="variable" {{old('type') == 'variable' ? 'selected' : ''}}>Variable</option>
                </select>
                @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>


        <div id="simple-stocks">
            <div class="form-group {{ $errors->has('stock') ? ' has-error' : '' }}">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="">Stock</label>
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control" type="number" name="stock" id="stock" value="{{old('stock')}}">
                        @if ($errors->has('stock'))
                            <span class="help-block">
                                <strong>{{ $errors->first('stock') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>                            
        </div>


        <div id="variants-container" style="{{$errors->has('variables') || $errors->has('values') ||  $errors->has('v_stocks') ? '' : 'display:none' }}">
            @include('forms.templates.add-variants')
        </div><!--variants-container-->

        

        
        <div class="form-group {{ $errors->has('base_price') ? ' has-error' : '' }}" >
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Base Price</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" type="number" name="base_price" id="base-price" value="{{old('base_price')}}">
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
                    <input class="form-control" type="number" name="selling_price" id="selling-price"  value="{{old('selling_price')}}">
                    @if ($errors->has('stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('selling_price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="text-center">
                    <img id="product-preview" src="{{asset('storage/images/products/default.png')}}" alt="Product preview" width="100%">
                    <div class="image-preview-container" replace="#product-preview"></div>
                </div>
                <div class="form-group">
                    <label for="preview" class="control-label grey">Preview Image (optional)</label>
                    <input type="file" name="preview" id="preview">
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <input class="btn btn-success" type="submit" value="Add Product">
        </div>

</form>
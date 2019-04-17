@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg" style="margin-top: 5px">
                <div class="card-header">
                    <h5>New Shop</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('shop.store')}}" method="post">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="shop name" value="{{old('name')}}" required> 
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('shop_address') ? ' has-error' : '' }}">
                            <label for="">Address</label>
                            <input type="text" name="shop_address" class="form-control" placeholder="shop address" value="{{old('shop_address')}}" required> 
                            @if ($errors->has('shop_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_address') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('shop_phone') ? ' has-error' : '' }}">
                            <label for="">Phone</label>
                            <input type="text" name="shop_phone" class="form-control" placeholder="shop phone number(s)" value="{{old('shop_phone')}}"> 
                            @if ($errors->has('shop_phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('shop_email_address') ? ' has-error' : '' }}">
                            <label for="">Email</label>
                            <input type="text" name="shop_email_address" class="form-control" placeholder="shop email address" value="{{old('shop_email_address')}}"> 
                            @if ($errors->has('shop_email_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop_email_address') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="text-muted">
                            <i class="fa fa-info-circle"></i> shop name, address, phone and email provided will appear on customer receipts
                        </div>

                        <div class="form-group {{ $errors->has('about_shop') ? ' has-error' : '' }}">
                            <label for="">About</label>
                            <textarea name="about_shop" class="form-control" placeholder="about this shop ...">{{old('about_shop')}}</textarea>
                            @if ($errors->has('about_shop'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('about_shop') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block theme-btn">create shop</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


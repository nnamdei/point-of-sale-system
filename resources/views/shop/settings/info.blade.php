<form action="{{route('shop.update',[$shop->id])}}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" placeholder="shop name" value="{{$shop->name}}" required> 
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group d-flex">
        <label for="" class="mr-2">Theme:</label>
        <div>
            <input type="color" name="theme_color" value="{{$shop->setting->theme()}}">
            <span class="text-muted">{{$shop->setting->theme()}}</span>
        </div>
    </div>

    <div class="form-group {{ $errors->has('shop_phone') ? ' has-error' : '' }}">
        <label for="">Phone</label>
        <input type="text" name="shop_phone" class="form-control" placeholder="shop phone number(s)" value="{{$shop->phone}}"> 
        @if ($errors->has('shop_phone'))
            <span class="help-block">
                <strong>{{ $errors->first('shop_phone') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('shop_email_address') ? ' has-error' : '' }}">
        <label for="">Email</label>
        <input type="text" name="shop_email_address" class="form-control" placeholder="shop email address" value="{{$shop->email}}"> 
        @if ($errors->has('shop_email_address'))
            <span class="help-block">
                <strong>{{ $errors->first('shop_email_address') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('shop_address') ? ' has-error' : '' }}">
        <label for="">Address</label>
        <input type="text" name="shop_address" class="form-control" placeholder="shop address" value="{{$shop->address}}" required> 
        @if ($errors->has('shop_address'))
            <span class="help-block">
                <strong>{{ $errors->first('shop_address') }}</strong>
            </span>
        @endif
    </div>
    <div class="text-muted">
        <i class="fa fa-info-circle"></i> shop name, address, phone and email provided will appear on customer receipts
    </div>

    <div class="form-group {{ $errors->has('about_shop') ? ' has-error' : '' }}">
        <label for="">About</label>
        <textarea name="about_shop" class="form-control">{{$shop->about}}</textarea>
        @if ($errors->has('about_shop'))
            <span class="help-block">
                <strong>{{ $errors->first('about_shop') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn theme-btn">save</button>
    </div>
</form>
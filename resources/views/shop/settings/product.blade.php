<form action="{{route('shop.setting.product',[$shop->id])}}" method="post">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="product-activation" name="product_activation" value="true" {{$shop->setting->productActivated() ? 'checked' : ''}}>
            <label class="custom-control-label" for="product-activation"> Enable product</label>
        </div>
        <p class="text-muted"><i class="fa fa-info-circle"></i> By enabling product, products can be added to <strong>{{$shop->name}}</strong> and sales can be recorded</p>
    </div>
    <hr>
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="low-stock-activation" name="low_stock_warning_activation" value="true" {{$shop->setting->lowStockWarningActivated() ? 'checked' : ''}}>
            <label class="custom-control-label" for="low-stock-activation"> Enable low stock warning</label>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="" class="col-8">Start showing low stock warning when stock is less or equals to </label>
        <div class="col-4">
            <input type="number" class="form-control" name="low_stock" value="{{$shop->setting->lowStock()}}">
        </div>
    </div>
    <hr>
    <!-- <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="scanner-activation" name="scanner_activation" value="true" {{$shop->setting->scannerActivated() ? 'checked' : ''}} {{!$_software::first()->isPremium() ? 'disabled': ''}}>
        <label class="custom-control-label" for="scanner-activation"> Enable barcode scanner</label>
        @if(!$_software::first()->isPremium())
            <span class="text-info"><i class="fa fa-exclamation-triangle"></i> Available only in premium</span>
        @endif
    </div> -->

    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="scanner-activation" name="scanner_activation" value="true" >
        <label class="custom-control-label" for="scanner-activation"> Enable barcode scanner</label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn theme-btn">save</button>
    </div>

</form>
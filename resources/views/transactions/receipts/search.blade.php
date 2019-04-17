<form action="{{route('receipt.verify')}}" method="GET">
    @if($shop->setting->productActivated() && $shop->setting->serviceActivated())
    <div class="form-group text-center">
        <h6>Choose the receipt type</h6>
    </div>
    <div class="form-group text-center">
        <div class="form-check form-check-inline">
             <input class="form-check-input" id="sale-receipt" type="radio" name="receipt" value="sale">
            <label class="form-check-label" for="sale-receipt">Sale</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="service-receipt" type="radio" name="receipt" value="service">
            <label class="form-check-label" for="service-receipt">Service</label>
        </div>
    </div>
    @elseif($shop->setting->productActivated())
        <p class="text-center text-muted">verify sale receipt</p>
        <input type="hidden" name="receipt" value="sale">
    @elseif($shop->setting->serviceActivated())
         <p class="text-center text-muted">verify service receipt</p>
         <input type="hidden" name="receipt" value="service">
    @endif
    <div class="form-group">
            <div class="d-flex justify-content-center">
                <input class="form-control mb-2" type="search" name="ref" value="{{isset($_GET['ref']) ? $_GET['ref'] : ''}}" placeholder="Enter the transaction ref..." aria-label="Search" style="border-radius: 3px 0px 0px 3px">
                <button class="btn theme-btn mb-2" type="submit" style="border-radius: 0px 3px 3px 0px"><i class="fa fa-search"></i></button>
            </div>
    </div>
    
</form>
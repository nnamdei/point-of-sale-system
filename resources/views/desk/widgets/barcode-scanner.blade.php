@if(Auth::user()->hasShop() && Auth::user()->shop->setting->scannerActivated())
    <div class="d-flex align-items-center barcode-scanner" data-status>
        <form class="d-flex align-items-center mr-2" action="{{$action}}" method="post" autocomplete="off">
            @csrf
            <audio src class="scanner-aud" autoplay></audio>
            @if($action == route('scan.product'))
                <div class="text-center mr-2">
                    <div class="small text-muted">
                        scanner action 
                        @include('widgets.help',['help_text' => 'Switch this toggle to select how you want to use the scanner'])
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend" data-toggle="tooltip" title="use the scanner to view product">
                            <span class="input-group-text {{!session()->has('scanner_action') || session('scanner_action') == 'view_product' ? 'theme-bg' : ''}} scanner-action-tab" data-action="view_product">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        @if(Auth::user()->isAttendant())
                            <div class="input-group-append" data-toggle="tooltip" title="use the scanner to add product to cart">
                                <span class="input-group-text {{session()->has('scanner_action') && session('scanner_action') == 'add_to_cart' ? 'theme-bg' : ''}} scanner-action-tab" data-action="add_to_cart">
                                    <i class="fa fa-cart-plus"></i>
                                </span>
                            </div>
                        @elseif(Auth::user()->isAdminOrManager())
                            <div class="input-group-append" data-toggle="tooltip" title="use the scanner to capture barcode">
                                <span class="input-group-text {{session()->has('scanner_action') && session('scanner_action') == 'capture_barcode' ? 'theme-bg' : ''}} scanner-action-tab" data-action="capture_barcode">
                                    <i class="fa fa-clipboard"></i>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <img src="{{asset('storage/assets/barcode-scanner.png')}}" alt="" class="scanner-img" >
            <input type="text" class="form-control animated slower infinite scanner-receptor" name="content">
        </form>
        <div class="d-flex align-items-center">
            <i class="fa fa-toggle-off theme-color scanner-toggle" style="font-size: 30px"></i>
            <span class="ml-1 scanner-status">OFF</span> 
        </div>
    </div>
@else
<div class="mr-2">
    <img src="{{asset('storage/assets/barcode-scanner.png')}}" alt="" class="scanner-img" data-toggle="tooltip" title="Barcode scanner not enabled">
</div>
@endif

@if(Auth::user()->shop->setting->scannerActivated())
    <div class="d-flex align-items-center barcode-scanner" data-status>
        <form class="d-flex align-items-center mr-2" action="{{$action}}" method="post" autocomplete="off">
            @csrf
            <audio src class="scanner-aud" autoplay></audio>
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

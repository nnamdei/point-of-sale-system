@if($product->barcodes->count() > 0)
<div style="max-height: 100px; overflow: auto">
    @foreach($product->barcodes as $barcode)
        <div class="text-center mb-1">
            <img src="data:image/png;base64,{{$barcode->barcode}}" alt="barcode" class="barcode"/>
            <div>
                @if($barcode->isGenerated())
                    {{$barcode->serial}} {{$barcode->attribute}}
                @elseif($barcode->isAttached())
                    {{$barcode->barcode_content}}
                @endif
                <a href="{{route('product.barcode.print',[$barcode->id])}}" class="btn theme-btn btn-sm" title="print barcode"><i class="fa fa-print"></i></a>
            </div>
        </div>
    @endforeach
</div>
<div class="text-right">
    <form action="{{route('product.barcode.remove',[$product->id])}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="remove barcodes"><i class="fa fa-times"></i></button>
    </form>
</div>
@else
    <div class="text-center">
        <p class="text-muted">No barcode</p>
    </div>
    @if(Auth::user()->isAdminOrManager())
        @if($product->isSimple())
            <div class="text-center text-muted">
                @if(session()->has('captured_barcode') && session('captured_barcode') !== '')
                    <p>You recently captured the barcode <strong><code>{{session('captured_barcode')}}</code></strong></p>
                    <form action="{{route('product.barcode.attach',[$product->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="content" value="{{session('captured_barcode')}}">
                        <button type="submit" class="btn btn-sm theme-btn">Attach captured barcode</button>
                    </form>
                @else
                   <p><i class="fa fa-info-circle"></i> Turn on the scanner from above and capture the barcode to attach to this product</p> 
                @endif
            </div>
        @endif
    @endif
@endif

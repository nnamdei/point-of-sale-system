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
                    <p>Attach barcode from product</p>
                    @include('desk.widgets.barcode-scanner',['action' => route('product.barcode.attach',[$product->id])])
            </div>
        @endif
        @if($product->isSimple() || ($product->isVariable() && $product->variants->count() > 0))
            <div class="text-center text-muted">
                <form action="{{route('product.barcode.generate',[$product->id])}}" method="post">
                    @csrf
                    <button type="submit" class="btn theme-btn btn-sm"><i class="fa fa-sync"></i> Generate barcode</button>
                </form>
            </div>
        @endif
    @endif
@endif

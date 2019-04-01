<div class="row text-center">
    <div class="col-4">
        <div  class="stats-bold-figure-container">
            <h6>Total Stock</h6>
            <h1><span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{$product->stocksBreakDown()}}">{{$product->stocks()}}</span></h1>
        </div>
    </div>
    <div class="col-4">
        <div  class="stats-bold-figure-container"> 
            <h6>Total Sales</h6>
            <h1><span class="badge badge-success" data-toggle="tooltip" data-placement="top" title="{{$product->salesBreakDown()}}">{{$product->sales()}}</span></h1>
        </div>
    </div>
    <div class="col-4">
        <div class="stats-bold-figure-container">
            <h6>Remaining</h6>
            <h1><span class="badge {{$product->finished() ? 'animated flash infinite slow badge-danger' : ($product->stocksLow() ? 'badge-warning' :'badge-secondary')}}" data-toggle="tooltip" data-placement="top" title="{{$product->remainsBreakDown()}}">{{$product->remaining()}}</span></h1>
        </div>        
    </div>
</div>

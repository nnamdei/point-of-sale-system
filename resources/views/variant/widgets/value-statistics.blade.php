<h6><a href="{{route('variants.show',['id'=>$variant->id])}}">{{$variant->variable}} </a>: <span class="text-success">{{$value}}</span></h6>
@if($variant->isConsistent())
    <div class="row text-center" style="background-color: #f7f7f7; padding: 5px; border-radius: 5px">
        <div class="col-4">
            <p>Stock</p>
            <h4><span class="badge badge-primary">{{$variant->stocks()[$loop->index]}}</span></h4>
        </div>
        <div class="col-4">
            <p>Sale</p>
            <h4><span class="badge badge-success">{{$variant->sales()[$loop->index]}}</span></h4>
        </div>
        <div class="col-4">
            <p>Remaining</p>
            <h4><span class="badge badge-secondary">{{$variant->remainings()[$loop->index]}}</span></h4>
        </div>
    </div>
    <div class="text-right">
        <small class="grey"><i class="fa fa-clock"></i> updated {{$variant->updated_at->diffForHumans()}}</small>
    </div>
@else
    <small class="text-warning"><i class="fa fa-exclamation-triangle"></i>  Data inconsistent</small>
@endif
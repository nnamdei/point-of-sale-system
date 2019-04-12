<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
        <strong class="d-block mb-1"> <a href="{{route('products.show',['id' => $product->id])}}">{{$product->name}}</a> (&#8358; {{number_format($product->selling_price)}})</strong>
        <small>Category: <a href="{{route('categories.show',['id'=>$product->category->id])}}">{{$product->category->name}}</a></small>
    </div>
    <div class="mb-1">
        <small>{{$product->type}}</small>
        <div>
            <strong>{{number_format($product->remaining())}}</strong> available
        </div>
        <div class="description-container">
            @if($product->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
                {{$product->description}}
            @endif
    </div>
</div>
    <small class="grey"><i class="fa fa-user"></i> created by {{$product->user->fullname()}} {{$product->created_at->diffForHumans()}}</small>
    @if($product->created_at->diffForHumans() !== $product->updated_at->diffForHumans())
        <br>
        <small>last updated {{$product->updated_at->diffForHumans()}}</small>
    @endif
    <div class="operations-container">
        <a title="Inspect {{$product->name}}" href="{{route('products.show',['id'=>$product->id])}}"><i class="fa fa-eye"></i>  view product</a>
    </div>
</div>
<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex">
        <div class="mr-2">
            <img class="product-preview" src="{{$product->preview()}}" alt="{{$product->name}}" width="70px" height="70px">
        </div>
        <div>
            <strong class="d-block mb-1"> <a href="{{route('products.show',['id' => $product->id])}}">{{$product->name}}</a> (&#8358; {{number_format($product->selling_price)}})</strong>
            Category: @include('category.templates.category-name', ['category' => $product->category_()])
        </div>
    </div>
    <div class="mb-1">
        
        <div class="d-flex">
            <div class="mr-auto">
                Type: {{$product->type}}
            </div>
            <div class="ml-auto">
                @if($product->finished())
                    <i class="fa fa-exclamation-triangle text-danger animated flash infinite slow" style="font-size: 20px"></i>
                @elseif($product->stocksLow())
                    <i class="fa fa-exclamation-triangle text-warning animated flash infinite slow" style="font-size: 20px"></i>
                 @endif
                <strong>{{number_format($product->remaining())}}</strong> available
            </div>
        </div>
        <div class="p-2">
            @if($product->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
                {{$product->description}}
            @endif
        </div>
    </div>
    <div class="my-1">
        added {{$product->created_at->toDayDateTimeString()}}, {{$product->created_at->diffForHumans()}}
    </div>
    <div class="d-flex">
        <div class="ml-auto">
            @include('staff.templates.auth-user-name',['user' => $product->user()])
        </div>
    </div>
    <!-- @if($product->created_at->diffForHumans() !== $product->updated_at->diffForHumans())
        <div class="my-1">last updated {{$product->updated_at->diffForHumans()}}</div>
    @endif -->

    <div class="operations-container">
        <a title="Inspect {{$product->name}}" href="{{route('products.show',['id'=>$product->id])}}"><i class="fa fa-eye"></i>  view product</a>
    </div>
</div>
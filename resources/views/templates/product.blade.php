<div class="list-group-item list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
        @if(Auth::user()->isManager())
            <strong class="d-block mb-1"> <a href="{{route('products.show',['id' => $product->id])}}">{{$product->name}}</a></strong>
            <small>Category: <a href="{{route('categories.show',['id'=>$product->category->id])}}">{{$product->category->name}}</a></small>
        @else
            <strong class="d-block mb-1"> <a href="{{route('desk.product',['id' => $product->id])}}">{{$product->name}}</a></strong>
            <small>Category: <a href="{{route('desk.category',['id'=>$product->category->id])}}">{{$product->category->name}}</a></small>
        @endif
    </div>
    <div class="mb-1">
        <small>{{$product->type}}</small>
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
    @if(Auth::user()->isManager())
        <div class="operations-container">
            <a title="Inspect {{$product->name}}" href="{{route('products.show',['id'=>$product->id])}}"><i class="fa fa-eye"></i>  view product</a>
            <a title="edit product {{$product->name}}" class="text-info" style="font-size: 16px" href="{{route('products.edit', ['id'  => $product->id])}}"><i class="fa fa-pen"></i> edit</a>
            @include('products.templates.delete-btn')
        </div>
    @endif
</div>
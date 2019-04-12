<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
            <strong class="d-block mb-1"> <a href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}}</a></strong> {{$category->products()->count()}} products
    </div>
    <div class="mb-1">
        <div class="">
            @if($category->description == null)
                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
                <small>{{$category->description}}</small>
            @endif
    </div>
</div>
    <small class="grey"><i class="fa fa-user"></i> created by {{$category->user->fullname()}} {{$category->created_at->diffForHumans()}}</small>
    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
        <br>
        <small>last updated {{$category->updated_at->diffForHumans()}}</small>
    @endif
    @if(Auth::user()->isAdminOrManager())
        <div class="operations-container">
            <a title="inspect {{$category->name}}" href="{{route('products.index').'?filter=category&c='.$category->name}}"><i class="fa fa-eye"></i>  view products</a>
        </div>
    @endif
</div>
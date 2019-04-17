<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
        <strong class="d-block mb-1"> <a href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}}</a></strong> 
        {{$category->products()->count()}} products
    </div>
    <div class="mb-1">
        @if($category->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
        @else
            <small>{{$category->description}}</small>
        @endif
    </div>

    <div class="my-1">
        created {{$category->created_at->toDayDateTimeString()}}, {{$category->created_at->diffForHumans()}}
    </div>
    <div class="d-flex">
        <div class="ml-auto">
            @include('staff.templates.auth-user-name',['user' => $category->user()])
        </div>
    </div>
    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
        <div class="my-1">last updated {{$category->updated_at->diffForHumans()}}</div>
    @endif
    @if(Auth::user()->isAdminOrManager())
        <div class="operations-container">
            <a title="inspect {{$category->name}}" href="{{route('products.index').'?filter=category&c='.$category->name}}"><i class="fa fa-chart-line"></i>  view products inventory</a>
        </div>
    @endif
</div>


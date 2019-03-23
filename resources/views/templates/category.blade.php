<div class="list-group-item list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
        @if(Auth::user()->isManager())
            <strong class="d-block mb-1"> <a href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}}<sup class="badge badge-secondary"> {{$category->products->count()}}</sup></a></strong>
        @else
            <strong class="d-block mb-1"> <a href="{{route('desk.category',['id' => $category->id])}}">{{$category->name}}<sup class="badge badge-secondary"> {{$category->products->count()}}</sup></a></strong>
        @endif
    </div>
    <div class="mb-1">
        <div class="description-container">
            @if($category->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
            {{$category->description}}
            @endif
    </div>
</div>
    <small class="grey"><i class="fa fa-user"></i> created by {{$category->user->fullname()}} {{$category->created_at->diffForHumans()}}</small>
    @if($category->created_at->diffForHumans() !== $category->updated_at->diffForHumans())
        <br>
        <small>last updated {{$category->updated_at->diffForHumans()}}</small>
    @endif
    @if(Auth::user()->isManager())
        <div class="operations-container">
            <a title="inspect {{$category->name}}" href="{{route('products.index').'?filter=category&c='.$category->name}}"><i class="fa fa-eye"></i>  view products</a>
            <a title="edit category {{$category->name}}" class="text-info" style="font-size: 16px" href="{{route('categories.edit', ['id'  => $category->id])}}"><i class="fa fa-pen"></i> edit</a>
            @include('categories.templates.delete-btn')
        </div>
    @endif
</div>
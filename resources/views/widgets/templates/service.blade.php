<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
            <strong class="d-block mb-1"> <a href="{{route('service.show',['id' => $service->id])}}">{{$service->name}}</a></strong>
    </div>

    <div class="mb-1">
        <div class="description-container">
            @if($service->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
                {{$service->description}}
            @endif
        </div>
    </div>

    <small class="grey"><i class="fa fa-user"></i> created {{$service->created_at->diffForHumans()}}</small>
</div>
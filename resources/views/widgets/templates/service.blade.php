<div class="list-group-item no-radius list-group-item-action flex-column align-items-start has-operations" >
    <div class="d-flex w-100 justify-content-between">
            <strong class="d-block mb-1"> <a href="{{route('service.show',['id' => $service->id])}}">{{$service->name}}</a></strong>
    </div>

    <div class="mb-1">
        <div class="py-2">
            @if($service->description == null)
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
            @else
                {{$service->description}}
            @endif
        </div>
    </div>

    <div class="my-1">
        added {{$service->created_at->toDayDateTimeString()}}, {{$service->created_at->diffForHumans()}}
    </div>
    <div class="d-flex">
        <div class="ml-auto">
            @include('staff.templates.auth-user-name',['user' => $service->user()])
        </div>
    </div>
    @if($service->created_at->diffForHumans() !== $service->updated_at->diffForHumans())
        <div class="my-1">last updated {{$service->updated_at->diffForHumans()}}</div>
    @endif
</div>
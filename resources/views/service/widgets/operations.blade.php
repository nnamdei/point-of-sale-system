<a class="btn btn-info btn-sm m-1" title="edit service {{$service->name}}"  href="{{route('service.edit', [$service->id])}}"><i class="fa fa-pen"></i> edit</a>
<button class="btn btn-danger btn-sm m-1" data-toggle="collapse" data-target="#delete-service-{{$service->id}}-collapse" title="delete {{$service->name}}"><i class="fa fa-times"></i> delete</button>            
<div class="mt-1">
    <div class="collapse alert alert-danger" id="delete-service-{{$service->id}}-collapse" data-parent="body">
        <p>Are you sure you want to delete this service <strong>{{$service->name}} ???!</strong> in {{$service->shop->name}}</p>
        <form action="{{route('service.destroy',['id' => $service->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="collapse" data-target="#delete-service-{{$service->id}}-collapse" > <i class="fa fa-times"></i> No, I'll keep it</button>
            <button class="btn btn-danger btn-sm m-1"> <i class="fa fa-trash"></i> Yes,  delete</button>
        </form>
    </div>
</div>
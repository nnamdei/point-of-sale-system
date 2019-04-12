@if(Auth::user()->isAdmin())
    <div class="d-flex justify-content-end  py-3">
        <div class="m-1">
            <a href="{{route('staff.edit',['id'=>$staff->id])}}" class="btn btn-sm btn-info" ><i class="fa fa-pen"></i>  edit info</a>
        </div>
        @if($staff->isAttendant())
            <div class="m-1">
                @include('staff.widgets.operations.open-close-desk')
            </div>
        @endif
        <div class="m-1">
            <button class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#delete-staff-{{$staff->id}}-collapse"><i class="fa fa-trash"></i>delete</button>
        </div>
    </div>
    <div class="collapse" id="delete-staff-{{$staff->id}}-collapse">
        <form action="{{route('staff.destroy',[$staff->id])}}" method="post">
            @csrf
            @method('DELETE')
            <p>Are you sure you want to discard <strong>{{$staff->fullname()}}</strong></p>
            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#delete-staff-{{$staff->id}}-collapse"><i class="fa fa-times"></i> No, retain</button>
            <button type="submit" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Yes, delete</button>
        </form>
    </div>
    
@endif

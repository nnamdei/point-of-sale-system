@if(isset($staff) && $staff != null)
    <div class="d-flex align-items-center">
        <div>
            <img src="{{$staff->avatar()}}" alt="$staff->fullname()" class="avatar" width="40px" height="40px">
        </div>
        <div class="ml-1">
        @if(!$staff->trashed())
            <a href="{{route('staff.show',[$staff->id])}}">{{$staff->fullname()}}</a>
            @else
                <span class="text-danger" data-toggle="tooltip" title="staff account trashed since {{$staff->deleted_at->toDayDateTimeString()}}">{{$staff->fullname()}}  <i class="fa fa-exclamation-triangle animated flash infinite slow"></i></span>
            @endif
        </div>
    </div>

@else
    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> <i>staff not found</i> </small>
@endif

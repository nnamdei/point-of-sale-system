@if(isset($user) && $user != null)
    <div class="d-flex align-items-center">
        <div>
            <img src="{{$user->profile()->avatar()}}" alt="$user->profile()->fullname()" class="avatar" width="40px" height="40px">
        </div>
        <div class="ml-1">
            @if($user->revoked())
                @if($user->profile()->trashed())
                    <span class="text-danger" data-toggle="tooltip" title="user access revoked and staff account trashed">{{$user->profile()->fullname()}}</span>
                @else
                    <a href="{{route('staff.show',[$user->profile()->id])}}">{{$user->profile()->fullname()}}</a>
                    <span class="text-warning" data-toggle="tooltip" title="user access revoked"> <i class="fa fa-exclamation-triangle animated flash infinite slow" ></i></span>
                @endif
            @else
                @if($user->isStaff())
                    <a href="{{route('staff.show',['id' => $user->profile()->id])}}">{{$user->profile()->fullname()}}</a>
                @else
                    <span>{{$user->profile()->fullname()}}</span>
                @endif
            @endif
        </div>
    </div>
@else
    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> <i>user not found</i> </small>
@endif

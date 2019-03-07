<div class="list-group-item">
    <div class="row">
        <div class="col-3 text-center">
            <img src="{{$user->avatar()}}" alt="{{$user->fullname()}}" class="avatar" width="60px" height="60px">
        </div>
        <div class="col-9">
            <h5><a href="{{route('users.show',['id'=>$user->id])}}">{{$user->fullname()}}</a></h5>
            <small class="grey">{{$user->position()}}</small>
        </div>
    </div>

</div>
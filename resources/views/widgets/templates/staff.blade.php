<div class="list-group-item no-radius">
    <div class="row">
        <div class="col-3 text-center">
            <img src="{{$staff->avatar()}}" alt="{{$staff->fullname()}}" class="avatar" width="60px" height="60px">
        </div>
        <div class="col-9">
            <h5><a href="{{route('staff.show',['id'=>$staff->id])}}">{{$staff->fullname()}}</a></h5>
            <small class="grey">{{$staff->position}}</small>
        </div>
    </div>

</div>
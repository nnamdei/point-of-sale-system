<div class="list-group-item no-radius">
    <div class="d-flex">
        <div class="mr-2">
            <img src="{{$staff->avatar()}}" alt="{{$staff->fullname()}}" class="avatar" width="60px" height="60px">
        </div>
        <div>
            <h6><a href="{{route('staff.show',['id'=>$staff->id])}}">{{$staff->fullname()}}</a></h6>
            <p class="grey">{{$staff->position}} @ <a href="{{route('shop.show',[$staff->shop->id])}}">{{$staff->shop->name}}</a></p>
        </div>
    </div>

</div>
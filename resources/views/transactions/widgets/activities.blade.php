<h5>Activities</h5>
<ul class="list-group" style="max-height: 70vh; overflow: auto">
    @if($activities->count() > 0)
        @foreach($activities as $action)
            <li class="list-group-item py-1">
                <p>{!!$action->interprete()!!}</p>
                <div class="text-right grey">
                    <img src="{{$action->user->avatar()}}" alt="$action->user->fullname()" class="avatar" width="40px" height="40px">
                    <small><a href="{{route('users.show',['id' => $action->user->id])}}">{{$action->user->fullname()}}</a></small>
                    <small>
                        <br>
                        <i class="fa fa-clock"></i>{{$action->created_at->diffForHumans()}}
                    </small>                    
                </div>
            </li>
        @endforeach
    @else
    <li class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i>  No other action <br> {{isset($period) ? $period: ''}}</li>
    @endif
</ul>

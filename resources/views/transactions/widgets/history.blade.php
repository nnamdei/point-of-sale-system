<ul class="list-group" style="padding-top:30px">
    @if($transactions->count() > 0)
        @foreach($transactions as $transaction)
            <li class="list-group-item">
                {!!$transaction->interprete()!!}
                <div class="text-right grey">
                    
                    <img src="{{$transaction->user->avatar()}}" alt="$transaction->user->fullname()" class="avatar" width="40px" height="40px">
                    <small><a href="{{route('users.show',['id' => $transaction->user->id])}}">{{$transaction->user->fullname()}}</a></small>
                    <small>
                        <br>
                        <i class="fa fa-clock"></i>{{$transaction->created_at->diffForHumans()}}
                    </small>                    
                </div>

            </li>
        @endforeach
    @else
    <li class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i>  No other transaction <br> {{isset($period) ? $period: ''}}</li>
    @endif
</ul>

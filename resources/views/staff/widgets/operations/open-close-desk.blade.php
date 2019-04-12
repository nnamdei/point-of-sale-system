    @if($staff->user->deskClosed())
        <form action="{{route('desk.open',[$staff->user->id])}}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> open desk</button>
        </form>
    @else
        <form action="{{route('desk.close',[$staff->user->id])}}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> close desk</button>
        </form>
    @endif
</div>

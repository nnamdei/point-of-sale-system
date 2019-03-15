<form action="{{route('desk.open',[$user->id])}}" method="post">
    @csrf
    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> open desk</button>
</form>
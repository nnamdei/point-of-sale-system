<form action="{{route('desk.close',[$user->id])}}" method="post">
    @csrf
    <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> close desk</button>
</form>
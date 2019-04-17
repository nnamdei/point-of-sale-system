<form action="{{route('staff.position.change',[$staff->id])}}" method="post">
    @csrf
    @method('PUT')
    <input type="hidden" name="new_position" value="attendant">
    <button type="submit" class="btn btn-link">Attendant</button>
</form>
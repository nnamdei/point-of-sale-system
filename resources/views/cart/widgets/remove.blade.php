<form action="{{route('cart.remove',[$item->rowId])}}"  method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{$item->rowId}}">
    <button class="btn btn-link text-danger" type="submit" style="font-size: 10px"><i class="fa fa-times"></i> remove all {{$item->qty}} items</button>
</form>

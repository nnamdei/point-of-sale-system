<form action="{{route('service.record',[$service->id])}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Service rendered by</label>
        <select name="staff" class="form-control">
            <option value="">select staff</option>
            @if(Auth::user()->shop->staff()->count() > 0)
                @foreach(Auth::user()->shop->staff as $staff)
                    @if(!$staff->isAttendant() && !$staff->isManager())
                        <option value="{{$staff->id}}" {{old('staff') == $staff->id ? 'selected' : ''}}>{{$staff->fullname()}}</option>
                    @endif
                @endforeach
            @endif
        </select>
        <i class="fa fa-info-circle"></i> Only regular staff are considered to be able to render services
    </div>

    <div class="form-group">
        <label for="">Ammount paid</label>
        <input type="number" name="ammount_paid" value="{{$service->price}}"  class="form-control" required>
    </div>

    <div class="form-group">
        <label for="">Payment method</label>
        <select name="payment_method" id="" class="form-control " required>
            <option value="Cash">Cash</option>
            <option value="POS">POS</option>
            <option value="Transfer">Transfer</option>
        </select>
    </div>

    <div class="form-group">
        <a href="#" data-toggle="collapse" data-target="#customer-details"><i class="fa fa-user"></i>  Customer info</a>
    </div>
    <div class="collapse" id="customer-details" style="box-shadow: none">
        <div class="form-group">
            <label for="">Customer name</label>
            <input type="text" class="form-control" name="customer_name" value="{{old('customer_name')}}">
        </div>

        <div class="form-group">
            <label for="">Customer phone</label>
            <input type="text" class="form-control" name="customer_phone" value="{{old('customer_phone')}}">
        </div>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn theme-btn">Record service</button>
    </div>

</form>

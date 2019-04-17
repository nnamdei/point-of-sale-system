<p class="text-danger">Are you sure you want to delete the shop <strong>{{$shop->name}}</strong> ? All categories <strong>({{$shop->categories->count()}} categories) , products ({{$shop->products->count()}} products), services ({{$shop->services->count()}} services), sales records and service records</strong> will be deleted permanently</p>
<button class="btn btn-outline-danger" data-toggle="collapse" data-target="#confirm-shop-delete">continue</button>
    <div class="collapse py-2" id="confirm-shop-delete" style="box-shadow: none">
        <form action="{{route('shop.destroy',[$shop->id])}}" method="post">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label for="">Alright sparky, just to be sure again, enter your password</label>
                <input type="password" class="form-control" placeholder="confirm your password" name="password">
            </div>
            <button class="btn btn-danger"><i class="fa fa-times"></i> DELETE</button>
        </form>
    </div>

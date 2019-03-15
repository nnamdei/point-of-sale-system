<form action="{{route('cart.show')}}" method="GET">
    <div class="">
            <div class="d-flex justify-content-center">
                <input class="form-control mb-2" type="search" name="ref" value="{{isset($_GET['ref']) ? $_GET['ref'] : ''}}" placeholder="Enter the transaction ref..." aria-label="Search" style="border-radius: 3px 0px 0px 3px">
                <button class="btn btn-success mb-2" type="submit" style="border-radius: 0px 3px 3px 0px"><i class="fa fa-search"></i></button>
            </div>
    </div>
</form>
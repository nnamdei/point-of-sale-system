<form action="{{route('products.index')}}" method="GET">
    <div class="form-group">
        <input class="form-control mb-2" type="search" name="search" value="{{isset($_GET['search']) ? $_GET['search'] : ''}}" placeholder="Enter keyword..." aria-label="Search">
    </div>
    
        <div class="form-group">
            <select name="sort" id="" class="form-control mb-2">
                <option value="stocks-9-0">highest stocks to lowest</option>
                <option value="stocks-0-9">lowest stocks to highest</option>
                <option value="sales-9-0">highest sales to lowest</option>
                <option value="sales-0-9">lowest sales to highest</option>
            </select>
    </div>
    <div class="form-group text-right">
        <button class="btn theme-btn mb-2" type="submit"><i class="fa fa-search"></i> search</button>
    </div>
</form>

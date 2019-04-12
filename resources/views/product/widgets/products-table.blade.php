    <div class="products-table-container" style="background-color: rgba(255,255,255,.8)">
        <table class="table table-striped table-dark table-hover  table-bordered products-table-head text-center" style="margin-bottom: 0">
            <thead>
                <tr class="white-bg">
                    <th colspan="4" style="border-top:none">
                        <h4 class='text-left'>
                            {{$insight->displaying}} - <span class="badge badge-success">{{$products == null ? 0 : $products->count()}}</span>
                        </h4>
                    </th>
                    <th>
                        <h6>Overall Stocks: <span class="badge badge-primary">{{$insight->totalStocks}}</span></h6>
                        <h6>Overall Sales: <span class="badge badge-success">{{$insight->totalSales}}</span></h6>
                        <h6>Overall Remaining: <span class="badge badge-secondary">{{$insight->totalRemaining}}</span></h6>
                    </th>
                    <th>
                        <h6>Average Stock: <br><span class="badge badge-primary">{{$insight->averageStocks()['figure']}}</span></h6>
                    </th>
                    <th>
                        <h6>Average Sale: <br><span class="badge badge-success">{{$insight->averageSales()['figure']}}</span></h6>
                    </th>
                </tr>

                <tr class="table-head-row">
                    <th class="id"><div>id</div></th>
                    <th  class="product"><div>Product</div></th>
                    <th  class="category"><div>Category</div></th>
                    <th  class="type"><div>Type</div></th>
                    <th  class="stock"><div>Stock</div></th>
                    <th  class="base-price"><div>Base Price</div></th>
                    <th  class="selling-price"><div>Selling Price</div></th>
                
                </tr>
            </thead>
        </table>

        <div class="products-table-body-container">
            <table class="table table-striped table-light table-hover table-bordered text-center products-table-body products-accordion">
                <tbody>
                    @if($products !== null && $products->count() > 0)
                        @foreach($products as $product)
                            @include('product.templates.product-row')
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No product found</small></td>
                        </tr>
                    @endif
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
    
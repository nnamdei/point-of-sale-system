    <div class="products-table-container" style="background-color: rgba(255,255,255,.8)">
        <table class="table  table-bordered products-table-head text-center bg-white" style="margin-bottom: 0">
            <thead>
                <tr>
                    <th colspan="4" style="border-top:none">
                        <h4 class='text-left'>
                            {{$insight->displaying}} - <span class="badge theme-bg">{{$products == null ? 0 : $products->count()}}</span>
                        </h4>
                    </th>
                    <th>
                        <h6>Overall Stocks: <span class="badge theme-bg">{{$insight->totalStocks}}</span></h6>
                        <h6>Overall Sales: <span class="badge theme-bg">{{$insight->totalSales}}</span></h6>
                        <h6>Overall Remaining: <span class="badge theme-bg">{{$insight->totalRemaining}}</span></h6>
                    </th>
                    <th>
                        <h6>Average Stock: <br><span class="badge theme-bg">{{$insight->averageStocks()['figure']}}</span></h6>
                    </th>
                    <th>
                        <h6>Average Sale: <br><span class="badge theme-bg">{{$insight->averageSales()['figure']}}</span></h6>
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
            <table class="table table-bordered text-center bg-white products-table-body products-accordion">
                <tbody>
                    @if($products !== null && $products->count() > 0)
                        @foreach($products as $product)
                            @include('product.templates.product-row')
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">
                                <div class="py-2 text-center text-muted">
                                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                                    No product found
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
    

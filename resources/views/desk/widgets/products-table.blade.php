<div class="products-table-container" style="background-color: rgba(255,255,255,.8)">
        <table class="table table-striped table-dark table-hover  table-bordered products-table-head text-center" style="margin-bottom: 0">
            <thead>
                <tr class="table-head-row">
                    <th class="id"><div>id</div></th>
                    <th  class="product"><div>Product</div></th>
                    <th  class="category"><div>Category</div></th>
                    <th  class="type"><div>Type</div></th>
                    <th  class="stock"><div>Stock</div></th>
                    <th  class="selling-price"><div>Price</div></th>
                
                </tr>
            </thead>
        </table>

        <div class="products-table-body-container">
            <table class="table table-light table-hover table-bordered text-center products-table-body products-accordion">
                <tbody>
                    @if($products !== null && $products->count() > 0)
                        @foreach($products as $product)
                            @include('desk.templates.product-row')
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
    

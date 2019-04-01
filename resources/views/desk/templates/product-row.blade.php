<tr class="product-row">
    <td  class="id">
        <div>
        #{{$product->id}}
        <br>
        @if($product->finished())
            <h1 class="text-center text-danger">
                <span class="animated flash infinite slow" data-toggle="tooltip" title='No stock remaining'><i class="fa fa-exclamation-triangle"></i></span>
            </h1>
        @elseif($product->stocksLow())
            <h1 class="text-center text-warning">
                <span class="animated flash infinite slow" data-toggle="tooltip" title='Stocks running low <span class="badge badge-warning"> {{$product->remaining()}}</span> remaining'><i class="fa fa-exclamation-triangle"></i></span>
            </h1>
        @endif
        </div>
    </td>
    <td  class="product" style="text-align: left">
        <div>

            @if($product->isVariable() && count($product->inconsistency()) > 0 )
            <?php $c = "<small class='text-danger'><i class='fa fa-exclamation-triangle'></i> There is inconsistency in $product->name variables: " ;
                foreach($product->inconsistency() as $ic){
                    $c .= "[ ".count($ic->values())." values of ".$ic->variable ." with ".count($ic->stocks())." different stocks and ".count($ic->sales)." different sales record found ]";
                }
                $c .= "</small>";
            ?>
            <span style="font-size: 15px" class="text-danger animated flash infinite" data-toggle="tooltip" data-placement="top" title="{{$c}}"><i class="fa fa-exclamation-triangle"></i></span>
            <?php unset($c) ?>
            @endif

            <a href={{route('desk.product',['id'=>$product->id])}} data-toggle="popover" data-trigger="hover" data-placement="bottom" data-title="{{$product->name}}" data-content="{{$product->description}}">{{$product->name}}</a>
            <img src="{{$product->preview()}}" alt="{{$product->name}}" width="100px">
        </div>
    </td>


    <td  class="category">
        <div>
            <a  href="{{route('desk.category',['id' => $product->category->id])}}" data-toggle="popover" data-trigger="hover" data-placement="bottom"  data-title="{{$product->category->name}} <span class='badge badge-primary'>{{$product->category->products->count() -1 }}</span> <small> more products</small>" data-content="{{$product->category->description}}" >{{$product->category->name}} </a>
        </div>
    </td>
    <td  class="type">
        <div>
            @if($product->isVariable())
                <span class="{{$product->variants->count() == 0 ? 'text-warning': ''}}" data-toggle="tooltip" data-placement="top" title="{!!$product->variables()!!}">{{$product->type}}</span> 
            @else
                {{$product->type}}
            @endif
        </div>
    </td>
    <td  class="stock">
        <div>
            @include('products.widgets.quick-figures')
            <div style="text-align: right" class="">
                @include('desk.widgets.add-to-cart')
            </div>
        </div> 
    </td>
    <td  class="selling-price"><div>&#8358; {{number_format($product->selling_price)}}</div></td>
</tr>
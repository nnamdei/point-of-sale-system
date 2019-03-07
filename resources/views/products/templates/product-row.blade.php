<tr class="product-row">
    <td  class="id">
        <div>
            #{{$product->id}}
            <br>
            @if($product->stocksLow())
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
            <span data-toggle="popover" data-trigger="hover" data-placement="bottom" data-title="{{$product->name}}" data-content="{{$product->description}}">{{$product->name}}</span>
            <img src="{{$product->preview()}}" alt="{{$product->name}}" width="100%">
            <div class="hidden" style="text-align: center">
                <div>
                    <small>
                            <a class="text-primary operations" href="{{route('products.show',['id' =>$product->id])}}" data-toggle="tooltip" data-placement="bottom" title="view {{$product->name}}"><i class="fa fa-eye"></i> </a>
                            <a class="text-info operations" href="{{route('products.edit',['id' =>$product->id])}}" data-toggle="tooltip" data-placement="bottom" title="edit {{$product->name}}"  ><i class="fa fa-pen"></i> </a>
                            @include('products.templates.delete-btn')
                    </small>
                </div>
            </div>
        </div>
    </td>


    <td  class="category">
        <div>
            <a  href="{{route('categories.show',['id' => $product->category->id])}}" data-toggle="popover" data-trigger="hover" data-placement="bottom"  data-title="{{$product->category->name}} <span class='badge badge-primary'>{{$product->category->products->count() -1 }}</span> <small> more products</small>" data-content="{{$product->category->description}}" >{{$product->category->name}} </a>
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
                @include('products.widgets.add-stock')
            </div>
        </div> 
    </td>
    <td  class="base-price"><div>{{number_format($product->base_price)}}</div></td>
    <td  class="selling-price"><div>{{number_format($product->selling_price)}} <br> <i class="fa fa-info"></i><sup  class="badge {{$product->profitIndexLevel() == 'good' ? 'badge-success' : ($product->profitIndexLevel() == 'fair' ? 'badge-warning' : 'badge-danger') }}">{{$product->profitIndex()}} %</sup></div></td>
</tr>
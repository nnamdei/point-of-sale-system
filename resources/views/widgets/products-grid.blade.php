<?php
 $product_w_collection = isset($products_w) ? $products_w : Auth::user()->shop->products()->orderBy('created_at','desc')->take(10)->get();
 $layout =  isset($grid_layout) ? $grid_layout : ['xs'=> 2, 'sm'=>2, 'md'=> 3];
?>
 @if($product_w_collection->count() > 0)
    <div class="row">
        @foreach($product_w_collection as $product)
            <div class="col-{{(12/$layout['xs'])}} col-sm-{{(12/$layout['sm'])}} col-md-{{(12/$layout['md'])}} p-0">
                <div class="m-1">
                    <div class="product-grid" style="background: {{themeColor()}} url('{{$product->preview()}}') center no-repeat; background-size: cover">
                        <div class="grid-details-container">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h6>{{$product->name}}</h6>
                                    <div class="">
                                        @if($product->finished())
                                            <i class="fa fa-exclamation-triangle text-danger animated flash infinite slow" style="font-size: 20px"></i>
                                        @elseif($product->stocksLow())
                                            <i class="fa fa-exclamation-triangle text-warning animated flash infinite slow" style="font-size: 20px"></i>
                                        @endif
                                        <strong>{{number_format($product->remaining())}}</strong> available
                                    </div>
                                </div>
                                <div class="col-4 price">
                                   <strong>{!!formatNum($product->selling_price)!!}</strong> 
                                </div>
                                
                            </div>
                            <div class="hidden-info p-2">
                                Category: @include('category.templates.category-name', ['category' => $product->category_()])
                                <div class="d-flex">
                                    <div class="mr-auto">
                                        Type: {{$product->type}}
                                    </div>
                                </div>
                                <div class="p-2">
                                    @if($product->description == null)
                                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> No description </small>
                                    @else
                                        {{$product->description}}
                                    @endif
                                </div>
                                <a title="Inspect {{$product->name}}" href="{{route('products.show',['id'=>$product->id])}}"><i class="fa fa-eye"></i>  view product</a>
                            </div>
                        </div>
                        @if(Auth::user()->isAttendant())
                            <div class="grid-cart">
                                @include('desk.widgets.add-to-cart', ['product' => $product])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="py-2 text-center text-muted">
        <h2><i class="fa fa-exclamation-triangle"></i></h2>
            No product found
    </div>
@endif
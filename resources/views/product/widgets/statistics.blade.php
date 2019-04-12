<div class="stats-container">
    <div class="card">
        <div class="card-header">Statistics</div>
        <div class="card-body">
            <div class="row text-center">

                <div class="col-12">
                    @include('product.widgets.quick-figures')
                    @if($product->isVariable())
                        <div class="row"  style="text-align:left">
                            <div class="col-12">
                                <div style="">
                                    @if($product->variants->count() > 0)
                                        <div class="">
                                            @foreach($product->variants as $variant)
                                                @include('variant.widgets.statistics')
                                           @endforeach
                                        </div>
                                        @if(Auth::user()->isAdminOrManager())
                                             <div class="text-right" style="margin: 5px">
                                                <a href="{{route('variants.edit',['id'=>$product->variants[0]->id])}}" class="btn btn-primary btn-sm">update {{$product->variants[0]->variable}}</a>  
                                                {{-- @include('variant.widgets.new-variant')--}}
                                            </div> 
                                        @endif
                                    @else
                                        <?php $target = "add-variable-to-product-".$product->id."-form".rand(10000,99999) ///This is to avoid conflict in the app accordion ?>
                                        @include('product.templates.no-variables')
                                    @endif                               
                                </div>

                            </div>

                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
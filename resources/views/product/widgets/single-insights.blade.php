<div class="text-center">
    @if($insight == null)
        <div class="alert alert-danger">
            <h1><i class="fa fa-exclamation-triangle"></i></h1>
            <p>Insight is not available. Set the product base price and selling price</p>
        </div>
    @else
        <div class="card">
                <div class="card-header">
                    <h5>PROFIT</h5> 
                </div>
                <div class="card-body">
                    <div class="text-right">
                        <span>Profit Index: <span class="badge {{$product->profitIndexLevel() == 'good' ? 'badge-success' : ($product->profitIndexLevel() == 'fair' ? 'badge-warning' : 'badge-danger') }}" data-toggle="tooltip" data-placement="bottom" title="{{$insight->profitIndex()['explanation']}}">{{$insight->profitIndex()['figure']}} %</span></span>
                    </div>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Current</th>
                            <th>Prospect</th>
                            <th>Expected Total</th>
                        </tr>
                        <tr>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->currentProfit()['explanation']}}">{{number_format($insight->currentProfit()['figure'])}}</span></h4>
                            </td>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->expectedOutstandingProfit()['explanation']}}">{{number_format($insight->expectedOutstandingProfit()['figure'])}}</span></h4>
                            </td>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->expectedTotalProfit()['explanation']}}">{{number_format($insight->expectedTotalProfit()['figure'])}}</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>STOCKS</h5> 
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Base Value</th>
                            <th>Expected Value</th>
                        </tr>
                        <tr>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class=""  data-toggle="tooltip" data-placement="top" title="{{$insight->stockBaseValue()['explanation']}}">{{number_format($insight->stockBaseValue()['figure'])}}</span></h4>
                            </td>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class=""  data-toggle="tooltip" data-placement="top" title="{{$insight->stockExpectedValue()['explanation']}}">{{number_format($insight->stockExpectedValue()['figure'])}}</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>SALES</h5> 
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Base Value</th>
                            <th>Expected Value</th>
                        </tr>
                        <tr>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->saleBaseValue()['explanation']}}">{{number_format($insight->saleBaseValue()['figure'])}}</span></h4>
                            </td>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->saleExpectedValue()['explanation']}}">{{number_format($insight->saleExpectedValue()['figure'])}}</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>OUTSTANDING</h5> 
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Base Value</th>
                            <th>Expected Value</th>
                        </tr>
                        <tr>
                            <td>
                                <span class="ngn">&#8358;</span>    
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->outstandingBaseValue()['explanation']}}">{{number_format($insight->outstandingBaseValue()['figure'])}}</span></h4>
                            </td>
                            <td>
                                <span class="ngn">&#8358;</span>
                                <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->outstandingExpectedValue()['explanation']}}">{{number_format($insight->outstandingExpectedValue()['figure'])}}</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif
</div>


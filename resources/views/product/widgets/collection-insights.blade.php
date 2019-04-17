<div class="text-center">
    <div class="card">
            <div class="card-header">
                <h5>PROFIT</h5> 
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Current</th>
                        <th>Prospect</th>
                        <th>Total Expected</th>
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
                            <h4><span class=""  data-toggle="tooltip" data-placement="top" title="{{$insight->stocksBaseValue()['explanation']}}">{{number_format($insight->stocksBaseValue()['figure'])}}</span></h4>
                        </td>
                        <td>
                            <span class="ngn">&#8358;</span>
                            <h4><span class=""  data-toggle="tooltip" data-placement="top" title="{{$insight->stocksExpectedValue()['explanation']}}">{{number_format($insight->stocksExpectedValue()['figure'])}}</span></h4>
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
                            <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->salesBaseValue()['explanation']}}">{{number_format($insight->salesBaseValue()['figure'])}}</span></h4>
                        </td>
                        <td>
                            <span class="ngn">&#8358;</span>
                            <h4><span class="" data-toggle="tooltip" data-placement="top" title="{{$insight->salesExpectedValue()['explanation']}}">{{number_format($insight->salesExpectedValue()['figure'])}}</span></h4>
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


</div>


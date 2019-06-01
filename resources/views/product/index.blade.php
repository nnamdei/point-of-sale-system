@extends('layouts.appRHSfixed')

@section('h-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection


@section('main')
<div class="bg-white mt-2" >
    
    <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="products-table-tab" data-toggle="tab" href="#products-table" role="tab" aria-controls="products-table" aria-selected="true"><i class="fa fa-table"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="products-stocks-chart-tab" data-toggle="tab" href="#products-stocks-chart" role="tab" aria-controls="products-stocks-chart" aria-selected="false"><i class="fa fa-chart-bar"></i> stocks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="products-sales-chart-tab" data-toggle="tab" href="#products-sales-chart" role="tab" aria-controls="products-sales-chart" aria-selected="false"><i class="fa fa-chart-bar"></i> sales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="products-remainings-chart-tab" data-toggle="tab" href="#products-remainings-chart" role="tab" aria-controls="products-remainings-chart" aria-selected="false"><i class="fa fa-chart-bar"></i> remains</a>
        </li>
        <li class="ml-auto">
            @include('product.widgets.sortable-search')
        </li>
    </ul>
       
    

    <div class="tab-content" id="myTabContent" style="overflow: auto">
        <div class="tab-pane fade show active" id="products-table" role="tabpanel" aria-labelledby="products-table-tab">
                @include('product.widgets.products-table')
        </div>
        <!--Table Tab-->

        <div class="tab-pane fade" id="products-stocks-chart" role="tabpanel" aria-labelledby="products-stocks-chart-tab">
                <?php
                    if(isset($stocksChart)){
                        $stocksChart->render();
                    }
                ?>
                <div id="stocks-chart-container"></div>
        </div> 
        <!-- Stock chart tab -->

        <div class="tab-pane fade" id="products-sales-chart" role="tabpanel" aria-labelledby="products-sales-chart-tab">
                <?php
                    if(isset($salesChart)){
                        $salesChart->render();
                    }
                ?>
                <div id="sales-chart-container"></div>
        </div>
        <!-- Sales chart tab -->

        <div class="tab-pane fade" id="products-remainings-chart" role="tabpanel" aria-labelledby="products-remainings-chart-tab">
                <?php
                    if(isset($remainingsChart)){
                        $remainingsChart->render();
                    }
                ?>
                <div id="remainings-chart-container"></div>
        </div>
        <!-- Remainings chart -->
    </div>

</div>
        
@endsection

@section('RHS')
<div class="rhs-fixed-head white text-center">
        <div class="theme-bg" style="height; padding: 15px 10px">
            <h4><i class="fa fa-eye"></i> Insights</h4>
        </div>
    </div>

    <div class="rhs-body">
        <div id="insights-container">
            @include('product.widgets.collection-insights')
        </div>
    </div>
@endsection

@section('styles')
    <style>

    </style>
@endsection
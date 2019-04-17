
{{--@include('templates.sales-disabled')--}}
<h6>Sales</h6>
<ul class="nav nav-tabs " id="salesTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="sales-table-tab" data-toggle="tab" href="#sales-table" role="tab" aria-controls="sales-table" aria-selected="true"><i class="fa fa-table" data-toggle="tooltip" title="show sales in table"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sales-chart-tab" data-toggle="tab" href="#sales-chart" role="tab" aria-controls="sales-chart" aria-selected="false"><i class="fa fa-chart-bar" data-toggle="tooltip" title="show sales in chart"></i></a>
  </li>
</ul>

<div class="tab-content" id="salesTabContent" style="max-height: 70vh; overflow: auto">
  <div class="tab-pane fade show active" id="sales-table" role="tabpanel" aria-labelledby="sales-table-tab">
        @include('transactions.templates.sales-table')
  </div>
  <div class="tab-pane fade" id="sales-chart" role="tabpanel" aria-labelledby="sales-chart-tab">
    @include('transactions.templates.sales-chart')
  </div>
</div>




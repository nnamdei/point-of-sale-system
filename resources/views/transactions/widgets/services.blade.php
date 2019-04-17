
<h6>Services</h6>
<ul class="nav nav-tabs " id="servicesTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="services-table-tab" data-toggle="tab" href="#services-table" role="tab" aria-controls="services-table" aria-selected="true"><i class="fa fa-table" data-toggle="tooltip" title="show services in table"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="services-chart-tab" data-toggle="tab" href="#services-chart" role="tab" aria-controls="services-chart" aria-selected="false"><i class="fa fa-chart-bar" data-toggle="tooltip" title="show services in chart"></i></a>
  </li>
</ul>

<div class="tab-content" id="servicesTabContent" style="max-height: 70vh; overflow: auto">
  <div class="tab-pane fade show active" id="services-table" role="tabpanel" aria-labelledby="services-table-tab">
        @include('transactions.templates.services-table')
  </div>
  <div class="tab-pane fade" id="services-chart" role="tabpanel" aria-labelledby="services-chart-tab">
    @include('transactions.templates.services-chart')
  </div>
</div>




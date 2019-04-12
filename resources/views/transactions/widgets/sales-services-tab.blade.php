<ul class="nav nav-tabs " id="sales-services-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#_sales" role="tab" aria-controls="_sales" aria-selected="true">Sales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="services-tab" data-toggle="tab" href="#_services" role="tab" aria-controls="_services" aria-selected="false">Services</a>
  </li>
</ul>

<div class="tab-content bg-white px-1" id="sales-services-tab-content" >
  <div class="tab-pane fade show active" id="_sales" role="tabpanel" aria-labelledby="sales-tab">
        @include('transactions.widgets.sales')
  </div>
  <div class="tab-pane fade" id="_services" role="tabpanel" aria-labelledby="services-tab">
    @include('transactions.widgets.services')
  </div>
</div>

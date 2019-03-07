
<?php echo $__env->make('templates.sales-disabled', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<ul class="nav nav-tabs " id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="sales-table-tab" data-toggle="tab" href="#sales-table" role="tab" aria-controls="sales-table" aria-selected="true">Sales Table</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sales-chart-tab" data-toggle="tab" href="#sales-chart" role="tab" aria-controls="sales-chart" aria-selected="false">Sales Chart</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="sales-table" role="tabpanel" aria-labelledby="sales-table-tab">
        <?php echo $__env->make('transactions.templates.sales-table', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="tab-pane fade" id="sales-chart" role="tabpanel" aria-labelledby="sales-chart-tab">
    <?php echo $__env->make('transactions.templates.sales-chart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>




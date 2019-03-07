<?php $__env->startSection('main'); ?>

<div style="padding: 10px 0">
<?php
    $today = new DateTime();
?>
    <a href="<?php echo e(route('transactions')); ?>" class="btn theme-btn" ><span class="badge badge-success"><?php echo e($today->format('d/m')); ?></span> Today </a>
    <button class="btn theme-btn" data-toggle="collapse" data-target="#day-filter" aria-expanded="false" aria-controls="#day-filter"><i class="fa fa-calendar"></i> A Specific Day</button>
    <button class="btn theme-btn" data-toggle="collapse" data-target="#period-filter" aria-expanded="false" aria-controls="#period-filter"><i class="fa fa-calendar-alt"></i> Range of Period</button>
    <?php if($TRANSACTIONS->count() > 0): ?>
    <a href="<?php echo e(route('transactions')); ?>?all=1" class="btn theme-btn" >All</a>
    <?php endif; ?>
    <div class="collapse" id="period-filter" data-parent="#app-accordion" style="margin-top: 5px">
        <form action="<?php echo e(route('transactions')); ?>" method="GET">
          
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control" type="date" name="from"  placeholder="yy-mm-dd">
                            <label for="" class="label-control grey">From</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control" type="date" name="to"  placeholder="yy-mm-dd">
                            <label for="" class="label-control grey">To</label>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="form-group">
                            <button class="btn theme-btn-alt" type="submit"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                </div>
           
        </form>
    </div>
    <div class="collapse" id="day-filter" data-parent="#app-accordion" style="margin-top: 5px">
        <form action="<?php echo e(route('transactions')); ?>" method="GET">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <input class="form-control" type="date" name="day" placeholder="yy-mm-dd">
                        <label for="" class="label-control grey">Select Day </label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <button class="btn theme-btn-alt" type="submit"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
        <?php echo $__env->make('transactions.widgets.sales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('RHS'); ?>
    <div class="rhs-fixed-head theme-bg" style="padding: 20px">
        <h4>Other Activities</h4>
        <div class="text-right">
            <small><?php echo e($period); ?></small>
        </div>
    </div>
    <div class="rhs-body">
        <?php echo $__env->make('transactions.widgets.history', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('head-scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/vendors/fusioncharts/fusioncharts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appRHSfixed', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
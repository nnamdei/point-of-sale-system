<table class="table table-striped table-light table-hover">
    <thead>
        <tr class="white-bg" >
            <td colspan="2" style="border-top:none">
                <h4 class="theme-secondary-color">Sales</h4>
                <h5 class="theme-color"><i class="fa fa-calendar theme-color"></i> <?php echo e($period); ?></h5>
            </td>
            <?php
                $totalSale = 0;
                foreach($sales as $s){
                    $totalSale += $s->price * $s->quantity;
                }
            ?>
            <td colspan="2"><h2 data-toggle="tooltip" title="Total sales: <?php echo e($period); ?>"><span class="badge badge-secondary">&#8358;<?php echo e(number_format($totalSale)); ?></span></h2></td>
            <td><i class="fa fa-arrow-up"></i> Highest Sold: 
                <?php if(isset($mostSold)): ?>
                    <a href="<?php echo e(Auth::user()->isManager() ? route('products.show',['id'=>$mostSold->product->id]) : route('desk.product',['id'=>$mostSold->product->id])); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($mostSold->total); ?> sold <?php echo e($period); ?>"> <?php echo e($mostSold->product->name); ?> <span class="badge badge-primary"><?php echo e($mostSold->total); ?></span></a>
                <?php else: ?>
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                <?php endif; ?>
            </td>
            <td>
                <i class="fa fa-arrow-down"></i> Least Sold:
                <?php if(isset($leastSold)): ?>
                    <a href="<?php echo e(Auth::user()->isManager() ? route('products.show',['id'=>$leastSold->product->id]) : route('desk.product',['id'=>$leastSold->product->id])); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($leastSold->total); ?> sold <?php echo e($period); ?>"> <?php echo e($leastSold->product->name); ?> <span class="badge badge-warning"><?php echo e($leastSold->total); ?></span></a>
                <?php else: ?>
                    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  Not availbale</small>
                <?php endif; ?>
             </td>
        </tr>
        <tr class="theme-secondary-bg">
            <td>id</td>
            <td>Product</td>
            <td>Category</td>
            <td>Price sold</td>
            <td>Quantity</td>
            <td>Value</td>
        </tr>
    </thead>
    <tbody>
    <?php if($sales->count() > 0): ?>
        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>#<?php echo e($sale->id); ?></td>
                 <td>
                 <img src="<?php echo e($sale->product->preview()); ?>" alt="<?php echo e($sale->product->name); ?>" width="100px">
                <?php if(Auth::user()->isManager()): ?>
                    <a href="<?php echo e(route('products.show',['id'=>$sale->product->id])); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e($sale->product->description); ?>">
                        <?php echo e($sale->product->name); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('desk.product',['id'=>$sale->product->id])); ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo e($sale->product->description); ?>">
                        <?php echo e($sale->product->name); ?>

                    </a>
                <?php endif; ?>
                <br>
                <small class="grey">
                    <span class="badge <?php echo e($sale->product->stocksLow() ? 'badge-warning animated flash infinite slow' : 'badge-secondary'); ?>"><?php echo e($sale->product->remaining()); ?></span> remaining
                </small>
                </td>
                <td><?php echo e($sale->product->category->name); ?></td>
                <td><?php echo e(number_format($sale->price)); ?></td>
                <td>
                    <?php echo e($sale->quantity); ?>

                <?php $product = $sale->product ?>
                    <?php if(Auth::user()->isManager()): ?>
                        <?php echo $__env->make('products.widgets.add-stock', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('products.widgets.add-sale', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endif; ?>

                </td>
                <td><?php echo e(number_format($sale->price * $sale->quantity)); ?>

                    <p class="text-right grey" style="margin: 0">
                        <?php if(Auth::user()->isManager()): ?>
                            <img src="<?php echo e($sale->user->avatar()); ?>" alt="$sale->user->fullname()" class="avatar" width="40px" height="40px">
                            <small><?php echo e($sale->user->fullname()); ?>, </small> <br>
                        <?php endif; ?>
                        <small><i class="fa fa-clock"></i> <?php echo e($sale->created_at->diffForHumans()); ?></small>
                    </p>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center"><i class="fa fa-info-circle"></i>  No Sales</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

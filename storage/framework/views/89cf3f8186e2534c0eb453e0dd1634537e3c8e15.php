<ul class="list-group" style="padding-top:30px">
    <?php if($transactions->count() > 0): ?>
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <?php echo $transaction->interprete(); ?>

                <div class="text-right grey">
                    
                    <img src="<?php echo e($transaction->user->avatar()); ?>" alt="$transaction->user->fullname()" class="avatar" width="40px" height="40px">
                    <small><a href="<?php echo e(route('users.show',['id' => $transaction->user->id])); ?>"><?php echo e($transaction->user->fullname()); ?></a></small>
                    <small>
                        <br>
                        <i class="fa fa-clock"></i><?php echo e($transaction->created_at->diffForHumans()); ?>

                    </small>                    
                </div>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <li class="list-group-item text-center"><i class="fa fa-exclamation-triangle"></i>  No other transaction <br> <?php echo e(isset($period) ? $period: ''); ?></li>
    <?php endif; ?>
</ul>

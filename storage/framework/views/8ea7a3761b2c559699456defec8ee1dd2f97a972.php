<script>
    <?php if(session('success')): ?>
            toastr.success("<?php echo session('success'); ?>");
    <?php endif; ?>
    <?php if(session('info')): ?>
            toastr.info("<?php echo session('info'); ?>");
    <?php endif; ?>

    <?php if(session('warning')): ?>
            toastr.warning("<?php echo session('warning'); ?>");
    <?php endif; ?>

    <?php if(session('error')): ?>
            toastr.error("<?php echo session('error'); ?>");
    <?php endif; ?>

    <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error('<?php echo e($error); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
    <?php endif; ?>

</script>
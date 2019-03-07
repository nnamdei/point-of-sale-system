<?php if(Auth::check()): ?>
	<?php if(Auth::user()->isManager()): ?>
		<?php echo $__env->make('layouts.inc.manager-nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		<?php echo $__env->make('layouts.inc.desk-nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
<?php endif; ?>
<?php echo $__env->make('layouts.inc.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

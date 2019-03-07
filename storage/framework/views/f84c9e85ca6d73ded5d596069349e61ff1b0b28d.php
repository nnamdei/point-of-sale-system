<!-- Scripts -->
<script src="<?php echo e(asset('js/vendors/jquery-3.3.1.js')); ?>"></script>
<script src="<?php echo e(asset('js/vendors/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vendors/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vendors/toastr.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vendors/typeahead.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/quick-search.js')); ?>"></script>
<script src="<?php echo e(asset('js/scripts.js')); ?>"></script>

<script>
			toastr.options = {
				"closeButton": true,
				"debug": true,
				"newestOnTop": true,
				"progressBar": true,
				"escapeHtml": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "0",
				"extendedTimeOut": "0",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
	</script>
<?php echo $__env->make('layouts.inc.toastr', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('scripts'); ?>

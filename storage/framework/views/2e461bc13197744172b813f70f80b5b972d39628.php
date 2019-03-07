<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
	<head>
		<?php echo $__env->make('layouts.inc.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</head>
	<body>
		<div id="app">
			<div id="app-accordion">
				<?php echo $__env->make('layouts.inc.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<div class="container-fluid">
					<div class="app-rhs-fixed">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-no-padding-xs">
								<div class="content">
									<?php echo $__env->yieldContent('main'); ?>
								</div>
							</div>
							
							<div class="col-md-3 col-sm-3">
								<div class="rhs-fixed">
									<div class="rhs-content">
										<?php echo $__env->yieldContent('RHS'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php echo $__env->make('layouts.inc.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</body>
</html>

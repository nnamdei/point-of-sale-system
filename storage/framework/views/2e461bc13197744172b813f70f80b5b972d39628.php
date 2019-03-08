<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
	<head>
		<?php echo $__env->make('layouts.components.meta-head', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('layouts.components.head-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('layouts.components.styles', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</head>
	<body>
		<div id="app">
			<?php echo $__env->make('layouts.components.nav', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<main>
				<div id="app-accordion">
					<div class="container-fluid">
						<div class="app-rhs-fixed">
							<div class="row">
								<div class="col-sm-9 col-no-padding-xs">
									<div class="content">
										<?php echo $__env->yieldContent('main'); ?>
									</div>
								</div>
								
								<div class="col-sm-3 col-no-padding-xs">
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
			</main>
		</div>
		
	<?php echo $__env->make('layouts.components.bottom-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</body>
</html>

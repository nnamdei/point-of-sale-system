<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<title><?php echo e(config('app.name', 'Inventory')); ?></title>

<!-- Styles -->
<link href="<?php echo e(asset('css/vendors/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/vendors/toastr.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/vendors/animate.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/vendors/normalize.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/layouts.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/search-result.css')); ?>" rel="stylesheet">
<?php echo $__env->yieldContent('styles'); ?>

<script  type="text/javascript" language="javascript" src="<?php echo e(asset('resrc/fontawesome-free-5.3.1-web/js/all.min.js')); ?>"></script>
<?php echo $__env->yieldContent('head-scripts'); ?>

<nav class="navbar navbar-expand-lg theme-secondary-bg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i>WESANI</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navigation-bar">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">

					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-products-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-box-open"></i> Products <sup class="badge badge-success"><?php echo e($PRODUCTS->count()); ?></sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-products-dropdown">
						<a class="dropdown-item" href="<?php echo e(route('products.create')); ?>"><i class="fa fa-plus"></i> Add new</a>
						<a class="dropdown-item" href="<?php echo e(route('products.index')); ?>">All Products</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-th-list"></i> Categories <sup class="badge badge-success"><?php echo e($CATEGORIES->count()); ?></sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown">
					<a class="dropdown-item" href="<?php echo e(route('categories.create')); ?>"><i class="fa fa-plus"></i> Create new</a>
						<?php if($CATEGORIES->count() > 0): ?>
							<?php $__currentLoopData = $CATEGORIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<a class="dropdown-item" href="<?php echo e(route('categories.show',['id' => $category->id])); ?>"><?php echo e($category->name); ?> <sup class="badge badge-secondary"><?php echo e($category->products->count()); ?></sup></a>
								<?php if(!$loop->last): ?>
									<div class="dropdown-divider"></div>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
							<h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No category added yet</h5>
						<?php endif; ?>
					</div>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo e(route('transactions')); ?>"><i class="fa fa-arrow-up"></i> Transactions</a>
				</li>
			</ul>

			<form action="<?php echo e(route('products.index')); ?>" class="form-inline my-2 my-lg-0 mr-2">
				<div class="form-row align-items-center">
					<div class="col-auto">
						<input class="form-control mb-2" type="search" name="search" value="<?php echo e(isset($_GET['search']) ? $_GET['search'] : ''); ?>" placeholder="Search for product" aria-label="Search">
					</div>
					
					 <div class="col-auto">
							<select name="sort" id="" class="form-control mb-2">
								<option value="stocks-9-0">highest stocks to lowest</option>
								<option value="stocks-0-9">lowest stocks to highest</option>
								<option value="sales-9-0">highest sales to lowest</option>
								<option value="sales-0-9">lowest sales to highest</option>
							</select>
					</div>
					<div class="col-auto" style="">
						<button class="btn btn-outline-success mb-2" type="submit"><i class="fa fa-search"></i></button>
					</div>

				</div>
			</form> 
				<?php echo $__env->make('widgets.todaySales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<div class="dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="<?php echo e(Auth::user()->avatar()); ?>" class="avatar" alt="<?php echo e(Auth::user()->firstname); ?>" width="30px" height="30px">	
						<small><?php echo e(Auth::user()->firstname); ?></small>
					</a>
					<div class="dropdown-menu" aria-labelledby="auth-user">
							<!--<a href="<?php echo e(route('users.create')); ?>" class="dropdown-item"><i class="fa fa-plus theme-color"></i> Add new user</a>-->
							<a href="<?php echo e(route('users.index')); ?>" class="dropdown-item"><i class="fa fa-user theme-color"></i> All Users</a>
							<a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out-alt"></i> Logout
							</a>
							<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
									<?php echo e(csrf_field()); ?>

							</form>
					</div>
				</div>

		</div>
	</nav>

<nav class="navbar navbar-expand-lg theme-secondary-bg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i></a>
		<div>
			@include('products.widgets.search')
		</div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa fa-bars white" style="font-size: 30px"></i>
		</button>

		<div class="collapse navbar-collapse" id="navigation-bar">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-products-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-box-open"></i> Products <sup class="badge badge-success">{{$_product::all()->count()}}</sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-products-dropdown">
						<a class="dropdown-item" href="{{route('products.create')}}"><i class="fa fa-plus"></i> Add new</a>
						<a class="dropdown-item" href="{{route('products.index')}}">All Products</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-th-list"></i> Categories <sup class="badge badge-success">{{$_category::all()->count()}}</sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown" style="max-height: 70vh; overflow: auto">
					<a class="dropdown-item" href="{{route('categories.create')}}"><i class="fa fa-plus"></i> Create new</a>
						@if($_category::all()->count() > 0)
							@foreach($_category::orderBy('name','asc')->get() as $category)
								<a class="dropdown-item" href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}} <sup class="badge badge-secondary">{{$category->products->count()}}</sup></a>
								@if(!$loop->last)
									<div class="dropdown-divider"></div>
								@endif
							@endforeach
						@else
							<h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No category added yet</h5>
						@endif
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-receipt-search-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-check-double"></i> Verify receipt
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-receipt-search-dropdown" style="width: 300px">
						<div class="p-2">
							@include('forms.search-cart')
						</div>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-product-search-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-search"></i> Search product
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-cart-product-search-dropdown" style="width: 300px">
						<div class="p-1">
							@include('products.widgets.sortable-search')
						</div>
					</div>
				</li>


				<li class="nav-item">
					<a class="nav-link" href="{{route('transactions')}}"><i class="fa fa-hand-holding-usd"></i> Transactions</a>
				</li>

			</ul>

			<!-- Right side nav -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					@include('widgets.today-sales')
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{Auth::user()->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
						<small>{{Auth::user()->firstname}}</small>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="auth-user">
							<a href="{{route('users.create')}}" class="dropdown-item"><i class="fa fa-plus theme-color"></i> Add new user</a>
							<div class="dropdown-divider"></div>
							<a href="{{route('users.index')}}" class="dropdown-item"><i class="fa fa-user theme-color"></i> All Users</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out-alt"></i> Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
							</form>
					</div>
				</li>
			</ul>
		</div>
	</nav>

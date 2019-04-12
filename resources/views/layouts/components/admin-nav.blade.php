<nav class="navbar navbar-expand-lg theme-secondary-bg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i></a>
		
        <div>
			@include('product.widgets.quick-search')
		</div>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa fa-bars white" style="font-size: 30px"></i>
		</button>

		<div class="collapse navbar-collapse" id="navigation-bar">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-shops-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-box-open"></i> {{Auth::user()->hasShop() ? Auth::user()->shop->name : 'Shops'}}
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-shops-dropdown" style="width: 250px">
						<a class="dropdown-item" href="{{route('shop.create')}}"><i class="fa fa-plus"></i> create new</a>
						<div class="dropdown-divider"></div>
							@if($_shop::all()->count() > 0)
								@foreach($_shop::orderBy('name','asc')->get() as $shop)
									@if(Auth::user()->hasShop() && $shop->id == Auth::user()->shop->id)
										<a href="{{route('shop.show',[$shop->id])}}" class="dropdown-item">
											<div class="d-flex align-items-start">
												<div>
													<i class="fa fa-check" style="font-size: 20px" title="Currently checked in {{$shop->name}}"></i>
												</div>
												<div class="ml-2">
													<span>{{$shop->name}}</span>
													<div>
														<small><i class="fa fa-map-marker"></i> {{$shop->address}}</small>
													</div>
												</div>
											</div>
										</a>
									@else
										<a href="{{route('shop.switch',[$shop->id])}}" class="dropdown-item" >
											<div class="d-flex align-items-center">
												<div>
													<i class="fa fa-sync" style="font-size: 20px" title="checkin {{$shop->name}}"></i>
												</div>
												<div class="ml-2">
													<span>{{$shop->name}}</span>
													<div>
														<small><i class="fa fa-map-marker"></i> {{$shop->address}}</small>
													</div>
												</div>
											</div>
										</a>
									
									@endif
									@if(!$loop->last)
										<div class="dropdown-divider"></div>
									@endif
								@endforeach
							@else
							<div class="list-group-item border-0">
								<h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No shop created yet</h5>
							</div>
							@endif

					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-products-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-box-open"></i> Products <sup class="badge badge-success">{{Auth::user()->shop->products->count()}}</sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-products-dropdown">
						<a class="dropdown-item" href="{{route('products.create')}}"><i class="fa fa-plus"></i> Add new</a>
						<a class="dropdown-item" href="{{route('products.index')}}">All Products</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-products-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-box-open"></i> Services <sup class="badge badge-success">{{Auth::user()->shop->services->count()}}</sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-products-dropdown">
						<a class="dropdown-item" href="{{route('service.create')}}"><i class="fa fa-plus"></i> Add new</a>
						<a class="dropdown-item" href="{{route('service.index')}}">All Services</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-th-list"></i> Categories <sup class="badge badge-success">{{Auth::user()->shop->categories->count()}}</sup>
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown" style="max-height: 70vh; overflow: auto">
						@if(Auth::user()->shop->categories->count() > 0)
							<a class="dropdown-item" href="{{route('categories.create')}}"><i class="fa fa-plus"></i> Create new</a>
							@foreach(Auth::user()->shop->categories as $category)
								<a class="dropdown-item" href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}} <sup class="badge badge-secondary">{{$category->products()->count()}}</sup></a>
								@if(!$loop->last)
									<div class="dropdown-divider"></div>
								@endif
							@endforeach
						@else
							<div class="text-danger text-center p-2"><i class="fa fa-exclamation-triangle"></i>  No category created yet <a href="{{route('categories.create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> create categpry</a></p>
						@endif
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-receipt-search-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-check-double"></i> Verify receipt
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-receipt-search-dropdown" style="width: 300px">
						<div class="p-2">
							@include('cart.widgets.search')
						</div>
					</div>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-product-search-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-search"></i> Search product
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-cart-product-search-dropdown" style="width: 300px">
						<div class="p-1">
							@include('product.widgets.sortable-search')
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
						<img src="{{Auth::user()->profile->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
						<small>{{Auth::user()->profile->firstname}}</small>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="auth-user">
							<a href="{{route('staff.create')}}" class="dropdown-item"><i class="fa fa-plus theme-color"></i> Add new staff</a>
							<div class="dropdown-divider"></div>
							<a href="{{route('staff.index')}}" class="dropdown-item"><i class="fa fa-user theme-color"></i> All staff</a>
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

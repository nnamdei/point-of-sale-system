<nav class="navbar navbar-expand-lg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i></a>
		@if(Auth::user()->hasShop() && Auth::user()->shop->setting->productActivated())
			<div>
				@include('product.widgets.quick-search')
			</div>
		@endif

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa fa-bars theme-color" style="font-size: 30px"></i>
		</button>

		<div class="collapse navbar-collapse" id="navigation-bar">
			<ul class="navbar-nav mr-auto">
				@if(Auth::user()->isAdmin())
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-shops-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
						<i class="fa fa-store-alt theme-color"></i> {{Auth::user()->hasShop() ? Auth::user()->shop->name : 'Shops'}}
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-shops-dropdown" style="width: 250px">
						<a class="dropdown-item" href="{{route('shop.create')}}"><i class="fa fa-plus"></i> create new</a>
						<div class="dropdown-divider"></div>
							@if($_shop::all()->count() > 0)
								<div style="max-height: 70vh; overflow: auto">
									@foreach($_shop::orderBy('name','asc')->get() as $shop)
										@if(Auth::user()->hasShop() && $shop->id == Auth::user()->shop->id)
											<a href="{{route('shop.show',[$shop->id])}}" class="dropdown-item">
												<div class="d-flex align-items-center">
													<div class="theme-color">
														<i class="fa fa-check" style="font-size: 20px" title="Currently checked in {{$shop->name}}"></i>
													</div>
													<div class="ml-2">
														<span>{{$shop->name}}</span>
														@if($shop->address != null)
															<div>
																<small><i class="fa fa-map-marker theme-color"></i> {{$shop->address}}</small>
															</div>
														@endif
													</div>
												</div>
											</a>
										@else
											<a href="{{route('shop.switch',[$shop->id])}}" class="dropdown-item" >
												<div class="d-flex align-items-center">
													<div>
														<i class="fa fa-store-alt theme-color" style="font-size: 20px" title="checkin {{$shop->name}}"></i>
													</div>
													<div class="ml-2">
														<span>{{$shop->name}}</span>
														<div>
															<small><i class="fa fa-map-marker theme-color"></i> {{$shop->address}}</small>
														</div>
													</div>
												</div>
											</a>
										
										@endif
									@endforeach
								</div>
								
							@endif
					</div>
				</li>
				@else
					<li class="nav-item">
						<a class="nav-link" href="{{route('shop.show',[Auth::user()->shop->id])}}"><i class="fa fa-store-alt theme-color"></i> {{Auth::user()->shop->name}}</a>
					</li>
				@endif

				@if(Auth::user()->hasShop() && Auth::user()->shop->setting->productActivated())
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-th-list theme-color"></i> Product categories <sup class="badge badge-secondary">{{Auth::user()->shop->categories->count()}}</sup>
						</a>
						<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown" >
							@if(Auth::user()->shop->categories->count() > 0)
								<a class="dropdown-item theme-color" href="{{route('categories.create')}}"><i class="fa fa-plus"></i> Create new</a>
								<div class="dropdown-divider"></div>
								<div style="max-height: 70vh; overflow: auto">
									@foreach(Auth::user()->shop->categories()->orderBy('name','asc')->get() as $category)
											<a class="dropdown-item" href="{{route('categories.show',['id' => $category->id])}}">{{$category->name}} <small> (<strong class="theme-color">{{$category->products->count()}}</strong> products)</small></a>
											<div class="dropdown-divider"></div>
									@endforeach
								</div>
							@else
								<div class="text-muted text-center p-2"><i class="fa fa-exclamation-triangle"></i>  No category created yet <a href="{{route('categories.create')}}" class="btn btn-sm theme-btn"><i class="fa fa-plus"></i> create category</a></p>
							@endif
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="nav-bar-products-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<i class="fa fa-box-open theme-color"></i> Products <sup class="badge badge-secondary">{{Auth::user()->shop->products->count()}}</sup>
						</a>
						<div class="dropdown-menu" aria-labelledby="nav-bar-products-dropdown">
							<a class="dropdown-item theme-color" href="{{route('products.create')}}"><i class="fa fa-plus"></i> Add new</a>
							<div class="dropdown-divider"></div>
							@if(Auth::user()->shop->products->count() > 0)
								<div style="max-height: 70vh; overflow: auto">
									@foreach(Auth::user()->shop->products()->orderBy('created_at','desc')->take(10)->get() as $p)
										<a class="dropdown-item" href="{{route('products.show',[$p->id])}}">
											<div class="d-flex">
												<img class="product-preview" src="{{$p->preview()}}" alt="{{$p->name}}" width="40px" height="40px">
												<div class="ml-2">
													{{$p->name}}
													<div class="text-right">
														<small>({{number_format($p->selling_price)}})</small>
													</div>
												</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
									@endforeach
								</div>
								
							@endif
							<div class="text-right">
								<a class="dropdown-item" href="{{route('products.index')}}">All Products</a>
							</div>
						</div>
					</li>

					@if(Auth::user()->hasShop() && Auth::user()->shop->setting->lowStockWarningActivated())
						<li class="nav-item">
							<a class="nav-link" href="{{route('shop.low.stocks',[Auth::user()->shop->id])}}">
								<i class="fa fa-exclamation-triangle theme-color"></i> Low stocks <sup class="badge badge-secondary">{{Auth::user()->shop->lowStockProducts()->count()}}</sup>
							</a>
						</li>
					@endif

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="nav-bar-product-search-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<i class="fa fa-search theme-color" ></i> Search product
						</a>
						<div class="dropdown-menu" aria-labelledby="nav-bar-cart-product-search-dropdown" style="width: 300px">
							<div class="p-1">
								@include('product.widgets.sortable-search')
							</div>
						</div>
					</li>

				@endif

				@if(Auth::user()->hasShop() && Auth::user()->shop->setting->serviceActivated())
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="nav-bar-services-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<i class="fa fa-toolbox theme-color"></i> Services <sup class="badge badge-secondary">{{Auth::user()->shop->services->count()}}</sup>
						</a>
						<div class="dropdown-menu" aria-labelledby="nav-bar-services-dropdown" style="max-height: 70vh;  min-width: 250px;  overflow: auto">
							<a class="dropdown-item" href="{{route('service.create')}}"><i class="fa fa-plus"></i> Add new</a>
							<div class="dropdown-divider"></div>
							@if(Auth::user()->shop->services->count() > 0)
								<div style="max-height: 70vh; overflow: auto">
									@foreach(Auth::user()->shop->services()->orderBy('created_at','desc')->take(10)->get() as $s)
										<a class="dropdown-item" href="{{route('service.show',[$s->id])}}"><i class="fa fa-toolbox theme-color"></i> {{$s->name}} <small>({{number_format($s->price)}})</small></a>
										<div class="dropdown-divider"></div>
									@endforeach
								</div>
							@endif
							<a class="dropdown-item" href="{{route('service.index')}}">All Services</a>
						</div>
					</li>
				@endif
				@if(Auth::user()->hasShop() && (Auth::user()->shop->setting->productActivated() || Auth::user()->shop->setting->serviceActivated()))
					<li class="nav-item">
						<a class="nav-link" href="{{route('transactions')}}"><i class="fa fa-hand-holding-usd theme-color"></i> Transactions</a>
					</li>
				@endif

			</ul>

			<!-- Right side nav -->
			<ul class="navbar-nav ml-auto">

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{Auth::user()->profile()->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
						<small>{{Auth::user()->profile()->firstname}}</small>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="auth-user">
							<a href="{{route('staff.create')}}" class="dropdown-item"><i class="fa fa-plus theme-color"></i> Add new staff</a>
							<div class="dropdown-divider"></div>
							<a href="{{route('staff.index')}}" class="dropdown-item"><i class="fa fa-user theme-color"></i> All staff</a>
							<div class="dropdown-divider"></div>
							@if(Auth::user()->isStaff())
								<a href="{{route('staff.show',[Auth::user()->profile()->id])}}" class="dropdown-item"><i class="fa fa-user theme-color"></i> My transactions</a>
								<div class="dropdown-divider"></div>
							@endif

							<a href="{{route('user.password.edit')}}" class="dropdown-item"><i class="fa fa-key theme-color"></i> Edit password</a>
							<div class="dropdown-divider"></div>

							<a href="{{route('barcode.generate')}}" class="dropdown-item"><i class="fa fa-barcode theme-color"></i> Generate barcode</a>
							<div class="dropdown-divider"></div>

							<a href="{{route('backup.index')}}" class="dropdown-item"><i class="fa fa-database theme-color"></i> Backup</a>
							<div class="dropdown-divider"></div>

							@if(Auth::user()->isSuperAdmin())
								<a href="{{route('system')}}" class="dropdown-item"><i class="fa fa-cog theme-color"></i> System ({{$_software::first()->status}})</a>
								<div class="dropdown-divider"></div>
							@endif

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

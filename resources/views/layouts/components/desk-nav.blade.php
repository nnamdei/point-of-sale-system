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

				<li class="nav-item">
					<a href="{{route('desk')}}" class="nav-link">Desk</a>
				</li>

				<li class="nav-item">
					<a href="{{route('desk.products')}}" class="nav-link">All Products</a>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Go to Category 
					</a>
					<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown" style="max-height: 70vh; overflow: auto">
						@if($_category::all()->count() > 0)
							@foreach($_category::orderBy('name','asc')->get() as $category)
								<a class="dropdown-item" href="{{route('desk.category',['id' => $category->id])}}">{{$category->name}} <sup class="badge badge-secondary">{{$category->products->count()}}</sup></a>
								@if(!$loop->last)
									<div class="dropdown-divider"></div>
								@endif
							@endforeach
						@else
							<h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No category added yet</h5>
						@endif
					</div>
				</li>

			</ul>
			<!-- Right side nav -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					@include('desk.widgets.cart')
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{Auth::user()->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
						<small>{{Auth::user()->firstname}}</small>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="auth-user">
							<div class="p-2 text-center">
								@include('widgets.today-sales')
							</div>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{route('users.show',[Auth::id()])}}">
								<i class="fa fa-hand-holding-usd"></i> My Transactions
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out-alt"></i>Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
							</form>
					</div>
				</li>
			</ul>
		</div>
	</nav>

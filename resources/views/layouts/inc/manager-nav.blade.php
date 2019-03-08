<nav class="navbar navbar-expand-lg theme-secondary-bg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i>{{config('app.name')}}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
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
					<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown">
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

				<li class="nav-item">
					<a class="nav-link" href="{{route('transactions')}}"><i class="fa fa-arrow-up"></i> Transactions</a>
				</li>
			</ul>

			<form action="{{route('products.index')}}" class="form-inline my-2 my-lg-0 mr-2">
				<div class="form-row align-items-center">
					<div class="col-auto">
						<input class="form-control mb-2" type="search" name="search" value="{{isset($_GET['search']) ? $_GET['search'] : ''}}" placeholder="Search for product" aria-label="Search">
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
				@include('widgets.today-sales')
				<div class="dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{Auth::user()->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
						<small>{{Auth::user()->firstname}}</small>
					</a>
					<div class="dropdown-menu" aria-labelledby="auth-user">
							<a href="{{route('users.create')}}" class="dropdown-item"><i class="fa fa-plus theme-color"></i> Add new user</a>
							<a href="{{route('users.index')}}" class="dropdown-item"><i class="fa fa-user theme-color"></i> All Users</a>
							<a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out-alt"></i> Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
							</form>
					</div>
				</div>

		</div>
	</nav>

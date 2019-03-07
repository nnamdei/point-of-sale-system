<nav class="navbar navbar-expand-lg theme-secondary-bg fixed-top">
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i>WESANI</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation-bar" aria-controls="navigation-bar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navigation-bar">
		<ul class="navbar-nav mr-auto">

			<li class="nav-item">
				<a href="{{route('desk')}}" class="nav-link">Desk</a>
			</li>

			<li class="nav-item active">
				@include('products.widgets.search')
			</li>
			<li class="nav-item">
				<a href="{{route('desk.products')}}" class="nav-link">All Products</a>
			</li>
			
			<li class="nav-item dropdown" style="margin-left: 50px">
				<a class="nav-link dropdown-toggle" href="#" id="nav-bar-categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Go to Category 
				</a>
				<div class="dropdown-menu" aria-labelledby="nav-bar-categories-dropdown">
					@if($CATEGORIES->count() > 0)
						@foreach($CATEGORIES as $category)
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
		
		@include('widgets.todaySales')
		<div class="dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="auth-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{Auth::user()->avatar()}}" class="avatar" alt="{{Auth::user()->firstname}}" width="30px" height="30px">	
				<small>{{Auth::user()->firstname}}</small>
			</a>
			<div class="dropdown-menu" aria-labelledby="auth-user">
					<a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
						<i class="fa fa-sign-out-alt"></i>Logout
						
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
					</form>
			</div>
		</div>

		</div>
	</nav>

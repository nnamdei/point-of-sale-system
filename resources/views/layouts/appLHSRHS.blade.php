<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
			@include('layouts.inc.head')
	</head>
	<body>
		<div id="app">
		   @include('layouts.inc.nav')
		   
		   <div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-no-padding-xs">
						<div class="lhs">
							@yield('LHS')
						</div>
					</div>
					<div class="col-sm-6 col-no-padding-xs">
						<div class="content">
							@yield('main')
						</div>
					</div>
					<div class="col-sm-3 col-no-padding-xs">
						<div class="rhs">
							@yield('RHS')
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@include('layouts.inc.scripts')
	</body>
</html>

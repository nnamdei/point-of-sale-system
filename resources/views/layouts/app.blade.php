<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
			@include('layouts.inc.head')
	</head>
	<body>
		<div id="app">
		   @include('layouts.inc.nav')
		   <div id="app-accordion">
			   <div class="container-fluid">
					<div class="content">
						@yield('main')
					</div>
				</div>
		   </div>
		   
		</div>

		@include('layouts.inc.scripts')
	</body>
</html>

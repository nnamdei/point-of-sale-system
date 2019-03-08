<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('layouts.components.meta-head')
        @include('layouts.components.head-scripts')
        @include('layouts.components.styles')
	</head>
	<body>
		<div id="app">
		   @include('layouts.components.nav')
		   <main>
				<div class="app-accordion">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-9 col-no-padding-xs">
								<div class="content">
									@yield('main')
								</div>
							</div>
							
							<div class="col-sm-3 col-no-padding-xs">
								<div class="rhs-content">
									@yield('RHS')
								</div>
							</div>
						</div>
					</div>
				</div>
		   </main>
		</div>
		
		@include('layouts.components.bottom-scripts')
	</body>
</html>

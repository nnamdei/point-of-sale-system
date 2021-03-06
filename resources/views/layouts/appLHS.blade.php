<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('layouts.components.meta-head')
        @include('layouts.components.head-scripts')
        @include('layouts.components.styles')
	</head>
	<body>
		<div id="app">
		   @include('layouts.inc.nav')
		   <main>
			   <div id="app-accordion">
					<div class="container-fluid">
						<div class="app-lhs">
							<div class="row">
								<div class=" col-sm-3 col-no-padding-xs">
									<div class="lhs-content">
										@yield('LHS')
									</div>
								</div>
								<div class="col-sm-9 col-no-padding-xs">
									<div class="content">
									@yield('main')
									</div>
								</div>
							</div>
						</div>
						
					</div>
			   </div>
				
		   </main>
		   
		</div>
		
	@include('layouts.inc.scripts')
	</body>
</html>

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
				<div id="app-accordion">
					<div class="container-fluid">
						<div class="app-dashboard">
							<div class="row">
								<div class="col-2">
									<div class="lhs-fixed">
										<div class="lhs-content">
											@yield('LHS')
										</div>
									</div>
								</div>

								<div class="col-10 col-no-padding-xs">
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
		
	@include('layouts.components.bottom-scripts')
	</body>
</html>

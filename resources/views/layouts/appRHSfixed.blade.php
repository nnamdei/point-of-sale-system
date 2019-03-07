<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		@include('layouts.inc.head')
	</head>
	<body>
		<div id="app">
			<div id="app-accordion">
				@include('layouts.inc.nav')
				<div class="container-fluid">
					<div class="app-rhs-fixed">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-no-padding-xs">
								<div class="content">
									@yield('main')
								</div>
							</div>
							
							<div class="col-md-3 col-sm-3">
								<div class="rhs-fixed">
									<div class="rhs-content">
										@yield('RHS')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	@include('layouts.inc.scripts')
	</body>
</html>

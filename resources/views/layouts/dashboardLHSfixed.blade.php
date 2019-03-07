<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		@include('layouts.inc.head')
	</head>
	<body>
		<div id="app">
			<div class="accordion" id="app-accordion">
		   		@include('layouts.inc.nav')
		    	<div class="container-fluid">
					<div class="dashboard-lhs-fixed">
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
		</div>
		
	@include('layouts.inc.scripts')
	</body>
</html>

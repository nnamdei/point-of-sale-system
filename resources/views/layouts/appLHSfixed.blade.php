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
					<div class="app-lhs-fixed">
						<div class="row">
							<div class="col-sm-3">
								<div class="lhs-fixed">
									<div class="lhs-content">
										@yield('LHS')
									</div>
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
		</div>
		
	@include('layouts.inc.scripts')
	</body>
</html>

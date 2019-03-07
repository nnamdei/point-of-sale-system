<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
			@include('layouts.inc.head')
	</head>
	<body>
		<div id="app">
           @include('layouts.inc.nav')
           <div id="app-accordion" style="margin-top: 5px">
               <div class="container-fluid">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
                                <div class="card">
                                    <div class="theme-secondary-bg card-header">
                                        <h5>@yield('header')</h5>
                                    </div>
                                    <div class="card-body">
                                         @yield('main')
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

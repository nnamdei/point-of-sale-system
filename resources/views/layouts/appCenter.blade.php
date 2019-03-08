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
                            <div class="app-center">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
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

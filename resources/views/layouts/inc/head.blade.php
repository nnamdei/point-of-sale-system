<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Inventory') }}</title>

<!-- Styles -->
<link href="{{ asset('css/vendors/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('css/layouts.css') }}" rel="stylesheet">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/search-result.css') }}" rel="stylesheet">
@yield('styles')

<script  type="text/javascript" language="javascript" src="{{asset('resrc/fontawesome-free-5.3.1-web/js/all.min.js')}}"></script>
@yield('head-scripts')

<?php  
        $theme_color = Auth::check() && Auth::user()->hasShop() ? Auth::user()->shop->setting->theme() : config('app.theme');
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="{{ $theme_color }}">
@if($_software::first()->cacheExpired())
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="{{now()->addDays($_software::first()->cache_age)->toRfc850String()}}" />
        @php
                $_software::first()->updateCache()
        @endphp
@endif
<title>{{ Auth::check() && Auth::user()->hasShop() ? Auth::user()->shop->name : config('app.name') }}</title>
<link rel="shortcut icon" href="{{asset('storage/assets/pos.png')}}" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

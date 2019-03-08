<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.components.meta-head')
        @include('layouts.components.head-scripts')
        @include('layouts.components.styles')
    </head>
    <body>
        <div id="app">
            <main>
                <div id="app-accordion">
                    <div class="container-fluid">
                        <div class="app">
                            <div class="content">
                                @yield('main')
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('layouts.components.bottom-scripts')
    </body>
</html>

@extends('layouts.plain')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-lg">
                @if($status == 'active')
                    <div class="card-body text-center">
                        <h1 class="text-success" style="font-size: 50px"><i class="fa fa-check-circle"></i></h1>
                        <h4 class="text-muted">Active</h4>
                        <div class="text-right">
                            <a href="{{route('index')}}">continue</a>
                        </div>
                    </div>
                @else
                    <div class="card-header text-center">
                        <h1><i class="fa fa-times text-center text-danger animated flash infinite slow" style="font-size: 50px"></i></h1>
                        <h4> System Unavailable</h4>
                    </div>
                    <div class="card-body text-center">
                        @switch($status)
                            @case ('inactive')
                                <p class="text-muted">System currently <strong>inactive</strong> </p>
                            @break

                            @case ('maintenance')
                                <p class="text-muted">System currently <strong>under maintenance</strong></p>
                            @break

                            @case ('bugged')
                                <p class="text-muted">Something went wrong, <strong>technical attention required</strong></p>
                            @break

                            @case ('blocked')
                                <p class="text-muted">System blocked</p>
                            @break
                        @endswitch

                        @if(Auth::check() && Auth::user()->isSuperAdmin())
                            <div class="text-right mt-2">
                                <a href="{{route('system')}}" class="btn btn-sm theme-btn"><i class="fa fa-cog"></i></a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        
        </div>
    </div>
@endsection
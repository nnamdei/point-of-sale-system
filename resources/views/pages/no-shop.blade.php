@extends('layouts.plain')

@section('main')
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h1 style="font-size: 60px" class="text-danger"><i class="fa fa-exclamation-triangle animated flash infinite slow"></i></h1>
                    <h4 class="text-muted">No shop checked in</h4>
                </div>
                <div class="card-body">
                    <p>{{Auth::user()->profile()->fullname()}}, you are currently not checked in any shop.</p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        @if(Auth::user()->isAdmin())
            <div class="col-md-6">
                @include('widgets.shops')
            </div>
        @endif

    </div>
@endsection
@extends('layouts.plain')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
            <h1>{{config('app.name')}}</h1>
                <h1 style="font-size: 60px" class="text-danger"><i class="fa fa-ban"></i></h1>
                <h2>No shop assigned</h2>
                <p>{{Auth::user()->profile->fullname()}}, you are currently not checked in any shop, contact the manager</p>
            
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>

            @if(Auth::user()->isAdmin())
                @if($_shop::all()->count() > 0)
                    @foreach($_shop::all() as $shop)
                        <li class="list-group-item d-flex">
                            <div>
                                <strong class="d-block">{{$shop->name}}</strong>
                                <small><i class="fa fa-map-marker"></i> {{$shop->address}}</small>
                            </div>
                            <a href="{{route('shop.switch',[$shop->id])}}" class="btn btn-sm btn-secondary ml-auto">checkin</a>
                        </li>
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i> No shop created yet <a href="{{route('shop.create')}}" class="btn btn-sm btn-success">create shop</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
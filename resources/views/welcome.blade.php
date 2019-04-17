@extends('layouts.app')

@section('main')
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="text-center">
                <h2>Welcome to {{config('app.name')}}</h2>
                <h6>Set up the admin account to start using {{config('app.name')}}</h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h6><i class="fa fa-user"></i> Admin Account</h6>
                </div>
                <div class="card-body">
                    @include('user.new-admin')
                </div>
            </div>
        </div>
    </div>
@endsection
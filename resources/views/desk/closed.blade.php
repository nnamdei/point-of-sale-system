@extends('layouts.plain')

@section('main')
    <div class="text-center">
       <h1>{{config('app.name')}}</h1>
        <h1 style="font-size: 60px" class="text-danger"><i class="fa fa-ban"></i></h1>
        <h2>Desk closed</h2>
        <p>{{Auth::user()->fullname()}}, your desk is currently closed, contact the manager</p>
    </div>
@endsection
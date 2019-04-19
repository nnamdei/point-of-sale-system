@extends('layouts.plain')
@section('main')
    <div class="bg-white p-5">
        <div class="text-center">
            <img src="data:image/png;base64,{{$barcode}}" alt="barcode" class="barcode"/>
            <div>
            {{$serial}}
            </div>
        </div>
        <div class="mt-2">
            <input type="text" class="form-control" autofocus>
        </div>
    </div>
@endsection
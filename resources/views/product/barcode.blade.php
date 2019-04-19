@extends('layouts.barcode')

@section('barcode')
    <img src="data:image/png;base64,{{$barcode->barcode}}" alt="barcode" class="barcode" >
    <br>
    <small style="font-size: 7px">{{$barcode->serial}} {{$barcode->attribute}}</small> 
@endsection
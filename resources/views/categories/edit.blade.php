@extends('layouts.appCenter')

@section('header')
    Edit Category: {{$category->name}}
@endsection

@section('main')
    @include('forms.edit-category')
@endsection

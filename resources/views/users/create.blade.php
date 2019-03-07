
@extends('layouts.app')

@section('main')

<div class="row" style="margin-top: 10px">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                New User
            </div>
            <div class="card-body">
                 @include('forms.new-user')
            </div>
        </div>
    </div>
</div>
   
@endsection

@section('scripts')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection

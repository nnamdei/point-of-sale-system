
@extends('layouts.app')

@section('main')

<div class="row justify-content-center mt-2" >
    <div class="col-md-4 col-no-padding-xs ">
        <?php 
            $staff_w = $staffs;
            $staff_w_title = 'Staff in '.Auth::user()->shop->name;
         ?>
        @include('widgets.staff')
    </div>
</div>
   
@endsection

@section('scripts')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection

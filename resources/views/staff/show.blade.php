
@extends('layouts.appRHSfixed')

@section('h-scripts')
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendors/fusioncharts/fusioncharts.theme.fusion.js')}}"></script>
@endsection

@section('main')
   <div class="theme-bg" style="margin-top:-5px; padding-top: 120px">
        <div class="white-bg" style="">
            <div class="row">
                <div class="col-sm-3 text-center">
                    <img src="{{$staff->avatar()}}" alt="{{$staff->fullname()}}" class="avatar" style="width: 200px; height: 200px; margin-top: -100px; border-width: 3px ">
                </div>
                <div class="col-sm-9  text-center">
                    <h5 class="theme-secondary-color">{{$staff->fullname()}}</h5>
                    <div>
                        <div class="d-flex justify-content-center">
                            <div>Shop:  <a href="{{route('shop.show',[$staff->shop->id])}}">{{$staff->shop->name}}</a></div>
                            <div class="ml-2">@include('staff.widgets.position')</div>
                            
                        </div>
                        
                        <small><i class="fa fa-clock"></i> Added {{ $staff->created_at->diffForHumans() }}</small>
                    </div>
                    @include('staff.widgets.operations')
                </div>
            </div>
        </div>
   </div>
   @if(Auth::user()->isAdminOrManager() || Auth::id() == $staff->id)
        <div class="card">
            <div class="card-header">
               {{'Transactions by '.$staff->firstname}} 
            </div>
            <div class="card-body">
                @include('transactions.widgets.filter')
                @if($staff->isAttendant() || $staff->isManager())
                    <p>Transactions recorded by {{$staff->fullname()}}</p>
                    @include('transactions.widgets.sales-services-tab')
                    @include('transactions.widgets.activities')
                @else
                    @include('transactions.widgets.services')
                @endif
            </div>
        </div>
    @endif
@endsection

@section('RHS')
<div style="margin-top: 5px">
    <?php
        $staff_w_title = "Other staff";
        $staff_w = $staff->shop->staff()->where('id','!=',$staff->id)->get();
    ?>
    @include('widgets.staff')
</div>
@endsection


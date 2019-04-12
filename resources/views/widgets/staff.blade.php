<?php $staff_w_collection = isset($staff_w) ? $staff_w : Auth::user()->shop->staff()->orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
            <h5>{{isset($staff_w_title) ? $staff_w_title: 'Staff' }}</h5>
            @if(Auth::user()->isAdminOrManager())
                <div class="text-right">
                    <a class="btn btn-secondary btn-sm"  href="{{route('staff.create')}}" role="button">
                        <i class="fa fa-plus-circle"></i>  Add new staff
                    </a>            
                </div>
            @endif
        </div>
       <div class="card-body no-padding">
            @if($staff_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($staff_w_collection as $staff)
                            @include('widgets.templates.staff')
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle"></i>  No staff found
                </div>
            @endif
       </div>
   </div>
  


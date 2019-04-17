<?php $staff_w_collection = isset($staff_w) ? $staff_w : Auth::user()->shop->staff()->orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
            <h6>{{isset($staff_w_title) ? $staff_w_title: 'Staff' }}</h6>
            @if(Auth::user()->isAdminOrManager())
                <div class="text-right">
                    <a class="btn btn-outline-secondary btn-sm"  href="{{route('staff.create')}}" role="button">
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
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                      No staff found
                </div>
            @endif
       </div>
   </div>
  


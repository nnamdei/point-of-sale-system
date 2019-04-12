<?php $service_w_collection = isset($services_w) ? $services_w : $_service::orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
       <h5>{{isset($services_w_title) ? $services_w_title: 'Services' }}</h5>
         @if(Auth::user()->isManager())
            <div class="text-right">
                <a href="{{route('service.create')}}" class="btn btn-secondary btn-sm" >
                    <i class="fa fa-plus-circle"></i>  Add New Service
                </a>            
            </div>
        @endif
        </div>
       <div class="card-body no-padding">
          @if($service_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($service_w_collection as $service)
                        @include('widgets.templates.service')
                    @endforeach
                </div>
            @else
                    <div class="alert alert-danger text-center">
                       <i class="fa fa-exclamation-triangle"></i>  No service found
                    </div>
            @endif

       </div>
   </div>
  


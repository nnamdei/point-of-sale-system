    <?php $service_w_collection = isset($services_w) ? $services_w : $_service::orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
       <h6>{{isset($services_w_title) ? $services_w_title: 'Services' }}</h6>
        @if(Auth::user()->isAdminOrManager())
            <div class="text-right">
                <a href="{{route('service.create')}}" class="btn btn-outline-secondary btn-sm" >
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
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                      No service found
                </div>
            @endif
       </div>
       @if($services_w instanceof \Illuminate\Pagination\LengthAwarePaginator )
        <div class="card-footer">
            {{$services_w->links()}}
        </div>
        @endif
   </div>



<?php $shops_w_collection = isset($shops_w) ? $shops_w : $_shop::orderBy('name','asc')->get() ?>
    <div class="card">
       <div class="card-header">
       <h6>{{isset($shops_w_title) ? $shops_w_title: 'Shops' }}</h6>
         @if(Auth::user()->isAdmin())
            <div class="text-right">
                <a href="{{route('shop.create')}}" class="btn btn-outline-secondary btn-sm" >
                    <i class="fa fa-plus-circle"></i>  create new
                </a>            
            </div>
        @endif
        </div>
       <div class="card-body no-padding">
          @if($shops_w_collection->count() > 0)
                <ul class="list-group">
                    @foreach($shops_w_collection as $shop)
                       <li class="list-group-item no-radius">
                            <div class="d-flex">
                                <a href="{{route('shop.show',[$shop->id])}}" >{{$shop->name}}</a>
                                @if(Auth::user()->isAdmin())
                                    @if(!$shop->checkedIn())
                                        <a href="{{route('shop.switch',[$shop->id])}}" class="ml-auto"><i class="fa fa-sync"></i> checkin</a>
                                    @else
                                        <a href="{{route('shop.show',[$shop->id])}}" class="ml-auto"><i class="fa fa-check"></i> checked in</a>
                                    @endif
                                    @endif
                            </div>
                            @if($shop->address != null)
                                <p><i class="fa fa-map-marker"></i> {{$shop->address}}</p>
                            @endif
                            <small>{{$shop->about}}</small>
                            <div class="d-flex align-items-center">
                                <div class="ml-auto">
                                    manager:
                                    @if($shop->hasManager())
                                        @include('staff.templates.staff-name',['staff' => $shop->manager()])
                                    @else
                                        <i class="fa fa-user-tie"></i> n/a
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    <i class="fa fa-user"></i> <span>{{$shop->staff->count()}} staff</span>
                                </div>

                                <div class="ml-auto">
                                    <i class="fa fa-box-open"></i> <span>{{$shop->products->count()}} products</span>
                                </div>

                                <div class="ml-auto">
                                    <i class="fa fa-toolbox"></i> <span>{{$shop->services->count()}} services</span>
                                </div>
                            </div>
                       </li>
                    @endforeach
                </ul>
            @else
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                      No shop found
                </div>
            @endif

       </div>
   </div>
  


<?php $shop_w_collection = isset($shops_w) ? $shops_w : $_shop::orderBy('name','asc')->get() ?>
    <div class="card">
       <div class="card-header">
       <h5>{{isset($shops_w_title) ? $shops_w_title: 'Shops' }}</h5>
         @if(Auth::user()->isAdminOrManager())
            <div class="text-right">
                <a href="{{route('shop.create')}}" class="btn btn-secondary btn-sm" >
                    <i class="fa fa-plus-circle"></i>  create new
                </a>            
            </div>
        @endif
        </div>
       <div class="card-body no-padding">
          @if($shop_w_collection->count() > 0)
                <ul class="list-group">
                    @foreach($shop_w_collection as $shop)
                       <li class="list-group-item no-radius">
                            <div class="d-flex">
                                <a href="{{route('shop.show',[$shop->id])}}" >{{$shop->name}}</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{route('shop.switch',[$shop->id])}}" class="ml-auto"><i class="fa fa-sync"></i> checkin</a>
                                @endif
                            </div>
                            <p><i class="fa fa-map-marker"></i> {{$shop->address}}</p>
                            <small>{{$shop->about}}</small>
                            <div class="d-flex">
                                <div class="ml-auto">
                                    <i class="fa fa-user-tie"></i> <span>{{$shop->hasManager() ? $shop->manager->fullname() : 'N/A'}}</span>
                                </div>
                                <div class="ml-auto">
                                    <i class="fa fa-user"></i> <span>{{$shop->staff->count()}} staff</span>
                                </div>

                                <div class="ml-auto">
                                    <i class="fa fa-box-open"></i> <span>{{$shop->products->count()}} products</span>
                                </div>
                            </div>
                       </li>
                    @endforeach
                </ul>
            @else
                    <div class="alert alert-danger text-center">
                        <p><i class="fa fa-exclamation-triangle"></i>  No shop found</p>
                    </div>
            @endif

       </div>
   </div>
  


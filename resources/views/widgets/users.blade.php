<?php $user_w_collection = isset($users_w) ? $users_w : $_user::orderBy('created_at','desc')->take(10)->get() ?>
    <div class="card">
       <div class="card-header">
            <h5>{{isset($users_w_title) ? $users_w_title: 'Users' }}</h5>
            @if(Auth::user()->isManager())
                <div class="text-right">
                    <a class="btn btn-secondary btn-sm"  href="{{route('users.create')}}" role="button">
                        <i class="fa fa-plus-circle"></i>  Add New User
                    </a>            
                </div>
            @endif
        </div>
       <div class="card-body no-padding">
            @if($user_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($user_w_collection as $user)
                        @if($user->id != 1 && $user->id != Auth::id())
                            @include('templates.user')
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center text-danger"style="padding: 20px">
                    <small><i class="fa fa-exclamation-triangle"></i>  No user found</small>
                </div>
            @endif

       </div>
   </div>
  


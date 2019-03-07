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
           @if(isset($users_w))
                @if($users_w->count() > 0)
                    <div class="list-group">
                        @foreach($users_w as $user)
                            @include('templates.user')
                        @endforeach
                    </div>
                @else
                <div class="text-center text-danger"style="padding: 20px">
                    <small><i class="fa fa-exclamation-triangle"></i>  No user found</small>
                </div>
                @endif
            @elseif($USERS->count() > 0)
                <div class="list-group">
                    @foreach($USERS as $user)
                        @include('templates.user')
                    @endforeach
                </div>
            @else
                <div class="text-center text-danger"style="padding: 20px">
                    <small><i class="fa fa-exclamation-triangle"></i>  No user found</small>
                </div>
            @endif

       </div>
   </div>
  


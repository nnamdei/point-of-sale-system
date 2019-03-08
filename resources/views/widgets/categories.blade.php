   <div class="card">
       <div class="card-header">
            <h5>{{isset($categories_w_title) ? $categories_w_title: 'Categories' }}</h5>
            @if(Auth::user()->isManager())
                <div class="text-right">
                    <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#new-category" role="button" aria-expanded="false" aria-controls="new-category">
                        <i class="fa fa-plus-circle"></i>  Add New Category
                    </a>            
                </div>
                <div class="collapse" id="new-category" data-parent="#app-accordion">
                        @include('forms.new-category')
                </div>
            @endif
        </div>
       <div class="card-body no-padding">
           @if(isset($categories_w))
                @if($categories_w->count() > 0)
                    <div class="list-group">
                        @foreach($categories_w as $category)
                            @include('templates.category')
                        @endforeach
                    </div>
                @else
                <div class="text-center text-danger"style="padding: 20px">
                    <small><i class="fa fa-exclamation-triangle"></i>  No category found</small>
                </div>
                @endif
            @elseif($_category::all()->count() > 0)
                <div class="list-group">
                    @foreach($_category::orderBy('name','asc')->get() as $category)
                        @include('templates.category')
                    @endforeach
                </div>
            @else
                <div class="text-center text-danger"style="padding: 20px">
                    <small><i class="fa fa-exclamation-triangle"></i>  No category found</small>
                </div>
            @endif

       </div>
   </div>
  


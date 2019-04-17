<?php $category_w_collection = isset($categories_w) ? $categories_w : Auth::user()->shop->categories()->orderBy('created_at','desc')->get() ?>
   <div class="card">
       <div class="card-header">
            <h6>{{isset($categories_w_title) ? $categories_w_title: 'Product categories' }}</h6>
            @if(Auth::user()->isAdminOrManager())
                <div class="text-right">
                    <a class="btn btn-outline-secondary btn-sm" href="{{route('categories.create')}}">
                        <i class="fa fa-plus-circle"></i>  Add New Category
                    </a>            
                </div>
            @endif
        </div>
       <div class="card-body no-padding">
            @if($category_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($category_w_collection as $category)
                        @include('widgets.templates.category')
                    @endforeach
                </div>
            @else
                <div class="py-2 text-center text-muted">
                    <h2><i class="fa fa-exclamation-triangle"></i></h2>
                      No category found
                </div>
            @endif

       </div>
   </div>
  


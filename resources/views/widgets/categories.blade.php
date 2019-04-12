<?php $category_w_collection = isset($categories_w) ? $categories_w : Auth::user()->shop->categories()->orderBy('created_at','desc')->get() ?>
   <div class="card">
       <div class="card-header">
            <h5>{{isset($categories_w_title) ? $categories_w_title: 'Categories' }}</h5>
            @if(Auth::user()->isAdminOrManager())
                <div class="text-right">
                    <a class="btn btn-secondary btn-sm" href="{{route('categories.create')}}">
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
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle"></i>  No category found
                </div>
            @endif

       </div>
   </div>
  


<?php $category_w_collection = isset($categories_w) ? $categories_w : $_category::orderBy('created_at','desc')->get() ?>
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
            @if($category_w_collection->count() > 0)
                <div class="list-group">
                    @foreach($category_w_collection as $category)
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
  


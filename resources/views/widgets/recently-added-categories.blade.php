<?php
    $recent_categories = $CATEGORIES_->OrderBy('created_at','desc')->get();
?>
<div class="card">
    <div class="card-header">
        <h5>Recently Added Categories</h5>
    </div>
    <div class="card-body no-padding">
        @if($recent_categories->count() > 0)
        <div class="list-group">
            @foreach($recent_categories as $category)
                @include('templates.category')
            @endforeach
        </div>
        @else
            <div class="alert alert-warning">No category created yet</div>
        @endif
    </div>
</div>
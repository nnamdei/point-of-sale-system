@if(isset($category) && $category != null)
    @if($category->trashed())
        <span class="text-danger">{{$category->name}} <i class="fa fa-exclamation-triangle animated flash infinite slow"  data-toggle="tooltip" title="category trashed"></i></a>
    @else
        <a href="{{route('categories.show',[$category->id])}}" data-toggle="tooltip" title="{{$category->description}} ({{$category->products()->count().' total products'}})">{{$category->name}}</a>
    @endif
@else
    <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> <i>category not found</i> </small>
@endif
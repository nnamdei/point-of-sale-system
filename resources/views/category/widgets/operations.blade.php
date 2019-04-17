<a class="btn btn-outline-info btn-sm m-1" title="edit category {{$category->name}}" href="{{route('categories.edit', ['id'  => $category->id])}}"><i class="fa fa-pen"></i> edit</a>
<button class="btn btn-outline-danger btn-sm m-1" data-toggle="collapse" data-target="#discard-category-{{$category->id}}-collapse" title="trash {{$category->name}}"><i class="fa fa-times"></i> Trash all products</button>            
<div class="collapse alert alert-danger" id="discard-category-{{$category->id}}-collapse" data-parent="body">
    All <strong>{{$category->products()->count()}} products</strong>  and their sales records in this category <strong>{{$category->name}}</strong> will be deleted also, Are you sure you want to delete category <strong>{{$category->name}}</strong> ???!
    <form action="{{route('categories.destroy',['id' => $category->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="collapse" data-target="#discard-category-{{$category->id}}-collapse" > <i class="fa fa-times"></i> No, I'll keep it</button>
        <button class="btn btn-danger btn-sm m-1" type="submit"> <i class="fa fa-trash"></i> Yes,  delete</button>
    </form>
</div>

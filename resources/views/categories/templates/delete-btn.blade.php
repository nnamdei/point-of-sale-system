<span title="discard category {{$category->name}}" class="text-danger" style="font-size: 16px;cursor: pointer" onclick="javascript: confirmDelete(this,'discard-category-{{$category->id}}-confirmation')"><i class="fa fa-trash"></i> discard</span>        
<div class="confirmation-container" id="discard-category-{{$category->id}}-confirmation">
    <p class="text-warning">Are you sure you want to remove category <strong>{{$category->name}} ???!</strong></p>
    <button class="btn btn-primary confirm-no">No</button>
    <button class="btn btn-danger confirm-yes">Yes,  discard</button>
    <form action="{{route('categories.destroy',['id' => $category->id])}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE">
    </form>
</div>
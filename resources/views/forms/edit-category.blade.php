<form action="{{route('categories.update',['id'=>$category->id])}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label for="">Name</label>
        <input class="form-control" type="text" name="name" value="{{$category->name}}" placeholder="category name">
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea class="form-control" name="description" id="" cols="30" rows="10" placeholder="category description">{{$category->description}}</textarea>
    </div>
    <div class="form-group text-center">
        <input class="btn btn-success" type="submit" value="Update Category">
    </div>
</form>
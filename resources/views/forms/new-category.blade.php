<form action="{{route('categories.store')}}" method="POST">
    {{csrf_field()}}
    <div class="form-group">
        <label for="">Name</label>
        <input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="category name">
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea class="form-control" name="description" id="" cols="30" rows="10" placeholder="category description"></textarea>
    </div>
    <div class="form-group text-center">
        <input class="btn btn-success" type="submit" value="Add Category">
    </div>
</form>
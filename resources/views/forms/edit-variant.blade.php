<form action="{{route('variants.update',['id'=>$variant->id])}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label for=""><strong> Rename variable</strong></label>
        <input class="form-control" type="text" name="variable" value="{{$variant->variable}}" placeholder="variable name (attribute)">
    </div>
        <label for=""><strong>Rename values</strong> </label>
            @foreach($variant->values() as $value)
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <input type="text" class="form-control" name="{{$value}}" value="{{$value}}" placeholder="value for {{$variant->variable}}">
                    </div>
                    <div class="col-8">
                        @include('variants.widgets.value-statistics')
                    </div>
                </div>
            </div>
            @endforeach
                <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#new-values-collapse" aria-expanded="false" aria-controls="#new-values-collapse"><i class="fa fa-plus"></i>  Add new value for {{$variant->variable}}</button>
                <div class="collapse" id="new-values-collapse" style="margin-top: 5px;">
                    <div id="new-value-form-groups-container">
                        <div class="form-group new-value-form-group">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" name="new_values[]" class="form-control" placeholder="new value for {{$variant->variable}}">
                                </div>
                                <div class="col-4">
                                    <input type="number" name="new_stocks[]" class="form-control" placeholder="add stock">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <span onclick="javascript: duplicate('.new-value-form-group','#new-value-form-groups-container')"><i class="fa fa-plus-circle text-primary"></i>
                    </div>
                </div>

    <div class="form-group text-center">
        <input class="btn btn-success" type="submit" value="Update Variants">
    </div>
</form>
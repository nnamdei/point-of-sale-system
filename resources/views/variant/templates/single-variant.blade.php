 <div class="{{ $errors->has('variables') || $errors->has('values') || $errors->has('v_stocks') ? ' has-error' : '' }} single-variant">  
    <div class="row">
        <div class="col-12">
            <label for="">Variant</label>
            <input class="form-control" type="text" name="variable" placeholder="variable name (e.g color, size...)" value="{{$variant['variable']}}">
            @if ($errors->has('variables'))
                <span class="help-block">
                    <strong>{{ $errors->first('variable') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-12">
            <label for="">Values</label>
            <input class="form-control" type="text" name="values" placeholder="values seperated with |" value="{{$variant['values']}}">
            @if ($errors->has('values'))
                <span class="help-block">
                    <strong>{{ $errors->first('values') }}</strong>
                </span>
            @endif
        </div>

        <!-- <div class="col-12">
            <label for="">Stock</label>
            <input class="form-control" type="text" name="v_stocks" placeholder="stock seperated with |" value="{{$variant['stocks']}}">
            @if ($errors->has('v_stocks'))
                <span class="help-block">
                    <strong>{{ $errors->first('v_stocks') }}</strong>
                </span>
            @endif
        </div> -->

    </div>
</div>
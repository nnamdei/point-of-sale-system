<table class="table table-striped table-dark">
    <tbody>
        <tr>
            <th colspan="5" style="text-transform: uppercase">
                {{$variant->variable}}
            </th>
        </tr>
        <tr>
            <th>Value</th>
            <th>Stocks</th>
            <th>Sales</th>
            <th>Remaining</th>
            <th><i class="fa fa-clock"></i>  last update</th>
        </tr>
        
        @if(count($variant->values()) > 0 && count($variant->stocks()) > 0 && count($variant->sales()) &&  count($variant->remainings()) > 0 && $variant->isConsistent())
            @foreach($variant->values() as $value)
            <tr>
                <td><small>{{$value}}</small></td>
                <td><small>{{$variant->stocks()[$loop->index]}}</small></td>
                <td><small>{{$variant->sales()[$loop->index]}}</small></td>
                <td><small>{{$variant->remainings()[$loop->index]}}</small></td>
                <td><small>{{$variant->updated_at->diffForHumans()}}</small></td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="5">
                <small class="text-danger text-center"><i class="fa fa-info-circle"></i> Inconsistency data</small>
            </td>
        </tr>
        @endif

    </tbody>
    <tfoot></tfoot>

</table>

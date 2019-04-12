        
        @if(count($variant->values()) > 0 && count($variant->stocks()) > 0 && count($variant->sales()) &&  count($variant->remainings()) > 0 && $variant->isConsistent())
            @foreach($variant->values() as $value)
                @include('variants.widgets.value-statistics')
            @endforeach
        @else
            <h6>{{$variant->variable}} : <small class="text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Inconsistent data</small></h6>
        @endif

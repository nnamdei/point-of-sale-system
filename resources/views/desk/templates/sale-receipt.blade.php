@extends('layouts.sale-receipt')

@section('items')

    @if($contents->count() > 0)
        <table>
            @foreach($contents as $item)
                <tr style="border-bottom: 2px solid #000;">
                    <td class="text-left">
                        {{$item->name}}
                        @if(count($item->options) > 0)
                            @foreach($item->options as $variant => $variable)
                            <div>
                                {{$variant}} : 
                                @foreach($variable as $value => $qty)
                                    {{$value}}({{$qty}})
                                @endforeach
                            </div>
                            @endforeach
                        @endif
                    </td>
                    <td  class="text-right">
                        N{{number_format($item->price)}} x {{$item->qty}}
                    </td>
                    <td class="text-right">
                        N{{number_format($item->total)}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td>Tax</td>
                <td class="text-right">{{Cart::tax()}}</td>
            </tr>
            <tr>
                <td></td>
                <th>Total</th>
                <th class="text-right">{{Cart::total()}}</th>
            </tr>
        </table>
    @else
        <h4 class="text-center">No Item</h4>
    @endif
    
@endsection
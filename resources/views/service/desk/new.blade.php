@extends('lsyouts.plain')

@section('main')
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-5">
            <form action="{{route('service.record')}}" method="POST">
                <div class="form-group">
                    <label for="">Service</label>
                    <select name="service" class="form-control">
                        <option value="">select service</option>
                        @if(Auth::user()->shop->services->count() > 0)
                            @foreach((Auth::user()->shop->services as $service)
                                <option value="{{$service->id}}">{{$service->name}} (N {{number_format($service->price)}})</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Staff</label>
                    <select name="service" class="form-control">
                        <option value="">select service</option>
                        @if(Auth::user()->shop->staff->count() > 0)
                            @foreach((Auth::user()->shop->staff as $staff)
                                <option value="{{$service->id}}">{{$staff->fullname}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                div
            </form>
        </div>
    </div>
@endsection
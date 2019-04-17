@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg" style="margin-top: 5px">
                <div class="card-header">
                    <h5>Edit service: {{$service->name}} in {{$service->shop->name}}</h5>
                </div>
                <div class="card-body">
                        <form action="{{route('service.update',[$service->id])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Service Name</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="name" placeholder="name" value="{{$service->name}}">
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Description <i><small>(optional)</small></i></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="" placeholder="product description">{{$service->description}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}" >
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Price</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="number" name="price" id="price"  value="{{$service->price}}">
                                        @if ($errors->has('price'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group text-center">
                                <input class="btn theme-btn" type="submit" value="Update service">
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



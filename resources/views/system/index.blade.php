@extends('layouts.plain')
@section('styles')
    <style>
        body{
            background: rgba(0,0,0,.8) !important;
        }
        .section{
            max-height: 80vh;
             overflow: auto
        }
        a,
        a:hover,
        .btn{
            color: red;
            background-color: #eee
        }
        .command{
            font-family: Courier;
            border-radius: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        code{
            background-color: #f7f7f7;
            padding: 5px;
            margin: 3px 0;
        }
    </style>
@endsection
@section('main')
        <div class="text-center white">
            <h4>System Panel</h4>
            <h5>{{$system->name}} {{$system->version}}</h5>
        </div>
        <div class="row justify-content-center white">
            <div class="col-md-4 col-sm-8 no-padding-xs section">
                <h6 class="text-center">Console output</h6>
                @if(isset($outputs) && count($outputs) > 0)
                    @foreach($outputs as $output)
                        <code>{{$output}}</code>
                    @endforeach
                @else
                    <code>No console output</code>
                @endif
            </div>
            <div class="col-md-4 col-sm-8 no-padding-xs section">
                <a href="{{route('index')}}" class="btn btn-sm"><i class="fa fa-home"></i> Index</a>
                <a href="{{route('system.cache.clear')}}" class="btn btn-sm"><i class="fa fa-sync"></i> clear system cache</a>
                <form action="{{route('system.artisan.run')}}" method="post" autofill="off" > 
                    @csrf
                    <div>
                        <h6 class="white">Run artisan command</h6>
                        <input type="text" class="form-control command" name="command" placeholder="artisan command..." value="{{old('command')}}" required>
                        <div class="row my-2">
                            <div class="col-6">
                                <input type="text" class="form-control command" name="parameter[]" placeholder="parameter..." value="{{old('parameter')}}">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control command" name="value[]" placeholder="value..." value="{{old('value')}}">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6">
                                <input type="text" class="form-control command" name="parameter[]" placeholder="parameter..." value="{{old('parameter')}}">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control command" name="value[]" placeholder="value..." value="{{old('value')}}">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6">
                                <input type="text" class="form-control command" name="parameter[]" placeholder="parameter..." value="{{old('parameter')}}">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control command" name="value[]" placeholder="value..." value="{{old('value')}}">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-6">
                                <input type="text" class="form-control command" name="parameter[]" placeholder="parameter..." value="{{old('parameter')}}">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control command" name="value[]" placeholder="value..." value="{{old('value')}}">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn">Run >>></button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-sm-8 no-padding-xs section">
                <form action="{{route('system.update')}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="">Package: {{$system->package}}</label>
                        <select name="package" class="form-control" id="">
                            <option value="basic" {{$system->package == 'basic' ? 'selected' : ''}}>Basic</option>
                            <option value="premium" {{$system->package == 'premium' ? 'selected' : ''}}>Premium</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Status: <span class="{{$system->status == 'active' ? 'text-success' : 'text-muted'}}">{{$system->status}}</span></label>
                        <select name="status" class="form-control" id="">
                            <option value="active" {{$system->status == 'active' ? 'selected' : ''}}>Active</option>
                            <option value="basic" {{$system->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                            <option value="maintenance" {{$system->status == 'maintenance' ? 'selected' : ''}}>Maintenance</option>
                            <option value="bugged" {{$system->status == 'bugged' ? 'selected' : ''}}>Bugged</option>
                            <option value="blocked" {{$system->status == 'blocked' ? 'selected' : ''}}>Blocked</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="">Cache age</label>
                        <input type="number" class="form-control" name="cache_age" value="{{$system->cache_age}}" required>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="clear-cache" name="clear_cache" value="clear">
                            <label class="custom-control-label" for="clear-cache">  Clear cache now</label>
                        </div>
                    </div>
-->
                    <div class="form-group">
                        <button class="btn btn-sm" type="button" data-toggle="collapse" data-target="#password-confirmation">update system</button>
                        <div class="collapse py-3" id="password-confirmation" style="box-shadow: none">
                            <p class="text-muted">Enter the administrator password to make changes to the system</p>
                            <input type="password" class="form-control" placeholder="password..." name="password" required>
                            <div class="mt-1">
                                <button class="btn btn-block" type="submit">UPDATE!</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    
@endsection
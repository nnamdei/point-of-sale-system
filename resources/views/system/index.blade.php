@extends('layouts.plain')
@section('styles')
    <style>
        body,
        [type="submit"]
        {
            background: #000 !important;
        }
        [type="submit"]{
            color: #fff
        }
    </style>
@endsection
@section('main')
        <div class="row justify-content-center mt-3">
            <div class="col-md-4 col-sm-8 no-padding-xs">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h6>System</h6>
                        <div class="text-right">
                            <a href="{{route('system.cache.clear')}}" class="btn btn-sm theme-btn"><i class="fa fa-sync"></i> clear system cache</a>
                            <br>
                            <a href="{{route('index')}}">Go Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h5>{{$system->name}}</h5>
                            <h6>{{$system->version}}</h6>
                        </div>
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
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" data-target="#password-confirmation">update system</button>
                                <div class="collapse py-3" id="password-confirmation" style="box-shadow: none">
                                    <p class="text-muted">Enter your password to update system</p>
                                    <input type="password" class="form-control" placeholder="password..." name="password" required>
                                    <div class="mt-1">
                                        <button class="btn btn-block" type="submit">UPDATE!</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
@endsection
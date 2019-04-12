@extends('layouts.appRHSfixed')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mt-2">
                <div class="card shadow-lg" >
                    <div class="card-header">
                        <div class="d-flex">
                            <h4>{{$service->name}}</h4>
                            <div class="ml-auto">&#8358; {{number_format($service->price)}}</div>
                        </div>
                        @if(Auth::user()->isAdminOrManager())
                            @include('service.widgets.operations')
                        @endif
                    </div>
                    <div class="card-body">
                        @if($service->description == null)
                            <div class="alert alert-warning text-center">
                                No description
                            </div>
                        @else
                            {{$service->description}}
                        @endif

                        <form action="{{route('service.record',[$service->id])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Service rendered by</label>
                                <select name="staff" class="form-control">
                                    <option value="">select staff</option>
                                    @if(Auth::user()->shop->staff()->count() > 0)
                                        @foreach(Auth::user()->shop->staff as $staff)
                                            @if(!$staff->isAttendant() && !$staff->isManager())
                                                <option value="{{$staff->id}}" {{old('staff') == $staff->id ? 'selected' : ''}}>{{$staff->fullname()}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fa fa-info-circle"></i> Only regular staff are considered to  
                            </div>

                            <div class="form-group">
                                <label for="">Ammount paid</label>
                                <input type="number" name="ammount_paid" value="{{$service->price}}"  class="form-control" required>
                            </div>

                            <div class="text-right">
                                <a href="#" data-toggle="collapse" data-target="#customer-details"><i class="fa fa-user"></i>  Customer info</a>
                            </div>
                            <div class="collapse" id="customer-details">
                                <div class="form-group">
                                    <label for="">Customer name</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{old('customer_name')}}">
                                </div>

                                <div class="form-group">
                                    <label for="">Customer phone</label>
                                    <input type="text" class="form-control" name="customer_phone" value="{{old('customer_phone')}}">
                                </div>
                            </div>
                            



                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Record service</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('RHS')
    <?php 
        $services_w_title = 'Other services in '.$service->shop->name;
        $services_w = Auth::user()->shop->services()->where('id', '!=', $service->id)->orderBy('name','asc')->get();
     ?>
     <div class="mt-1">
        @include('widgets.services')
     </div>
@endsection

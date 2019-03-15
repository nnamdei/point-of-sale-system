
    @extends('layouts.app')

@section('main')


            @if(Auth::check())
            
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-center bg-white p-3 mt-3">
                        <h3 class="theme-secondary-color" id="brand">{{config('app.name')}}</h3>
                        <h4>Welcome {{Auth::user()->fullname()}}</h4>
                        <div class="my-2">
                            @include('products.widgets.search')
                        </div>
                        @if(Auth::user()->isManager())
                            <a href="{{route('products.create')}}" class="btn btn-sm theme-btn-alt"><i class="fa fa-plus"></i>  Add New Product</a>
                            <a href="{{route('categories.create')}}" class="btn btn-sm theme-btn-alt"><i class="fa fa-plus"></i>  Create a category</a>
                        @else
                            <a href="{{route('desk')}}" class="btn btn-sm theme-btn-alt"><i class="fa fa-plus"></i> Go to Desk</a>
                        @endif
                    </div>
                    <div class="my-2">
                       {{-- @include('templates.sales-disabled')--}}
                    </div>
                </div>
            </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="bg-white p-3 text-center">
                            <h3 class="theme-secondary-color" id="brand">{{config('app.name')}}</h3>
                            @include('forms.login')
                        </div>
                    </div>
                </div>
            @endif

@endsection

@section('styles')
<style>

    #brand{
        margin: 20px 0;
    }

    @media (min-width: 576px){
        #container{
        margin: auto;
       
        }
        #brand{
            font-size: 80px;
            letter-spacing: 20px;
        }

    }
</style>
@endsection
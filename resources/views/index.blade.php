
    @extends('layouts.app')

@section('main')
    <div class="text-center" id="container">
        <h1 class="theme-secondary-color" id="brand">{{config('app.name')}}</h1>
        @if(Auth::check())
            <div class="text-center">
                <h4>Welcome {{Auth::user()->fullname()}}</h4>
                @if(Auth::user()->isManager())
                    <a href="{{route('products.create')}}" class="btn btn-lg theme-btn-alt"><i class="fa fa-plus"></i>  Add New Product</a>
                    <a href="{{route('categories.create')}}" class="btn btn-lg theme-btn-alt"><i class="fa fa-plus"></i>  Create a category</a>
                @else
                    <a href="{{route('desk')}}" class="btn btn-lg theme-btn-alt"><i class="fa fa-plus"></i> Go to Desk</a>
                @endif
                <div class="my-2">
                    @include('templates.sales-disabled')
                </div>
                <div class="row mt-5">
                    <div class="col-md-6 sm-8 offset-md-3 offset-sm-2">
                        @include('products.widgets.search')
                    </div>
                </div>
                
            </div>
        @else
        <a href="{{route('login')}}" class="btn btn-lg theme-btn-alt" data-toggle="collapse" data-target="#login-container" aria-extended="true" aria-controls="#login-container"><i class="fa fa-sign-in-alt"></i>  Login</a>
        <div class="collapse"   id="login-container" data-parent="#app-accordion">
            <div style="padding-top: 20px">
                <div class="row">
                    <div class="col-sm-4 offset-sm-4">
                        @include('forms.login')
                    </div>
                </div>
            </div>
            
        </div>
        @endif
    </div>
@endsection

@section('styles')
<style>
    #container{
       
    }
    #brand{
        font-size: 40px;
        letter-spacing: 10px;
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
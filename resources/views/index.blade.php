
    @extends('layouts.plain')

@section('main')
            @if(Auth::check())
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="text-center theme-gradient-alt-bg px-2  py-5 mt-3 index-container">
                        <h4 class="white" id="brand" style="text-transform: uppercase"><a href="{{route('shop.show',[Auth::user()->shop->id])}}">{{Auth::user()->shop->name}}</a></h4>
                        <p>{{Auth::user()->profile->fullname()}}</p>
                        @if(Auth::user()->isAdminOrManager())
                            <a href="{{route('products.create')}}" class="btn btn-sm theme-btn-alt m-1"><i class="fa fa-plus"></i>  Add New Product</a>
                            <a href="{{route('categories.create')}}" class="btn btn-sm theme-btn-alt m-1"><i class="fa fa-plus"></i>  Create a category</a>
                            <a href="{{route('service.create')}}" class="btn btn-sm theme-btn-alt m-1"><i class="fa fa-plus"></i>  New service</a>

                        @else
                            <a href="{{route('desk')}}" class="btn btn-sm theme-btn-alt"><i class="fa fa-plus"></i> Go to Desk</a>
                        @endif
                    </div>
                    <div class="my-2">
                       {{-- @include('templates.sales-disabled')--}}
                    </div>
                </div>
                @if(Auth::user()->isAdmin())
                    <div class="col-md-4">
                        <?php
                        $shops_w_title = 'checkin shop';
                        $shops_w = Auth::user()->otherShops();
                        ?>
                        @include('widgets.shops')
                    </div>
                @endif
            </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="theme-gradient-alt-bg px-2 py-5 text-center index-container">
                            <h4 class="white" id="brand">{{config('app.name')}}</h4>
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
    .index-container{
        box-shadow: 0px 10px 10px rgba(0,0,0,.2);
        border-radius: 5px;
    }
    @media (min-width: 576px){
        #container{
        margin: auto;
       
        }
    }
</style>
@endsection
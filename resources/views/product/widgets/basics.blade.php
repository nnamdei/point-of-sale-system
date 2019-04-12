<div class="card">
    <div class="card-header">
        <h6>Info</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="list-group">
                    <div class="list-group-item">
                        Added by 
                        <img class="avatar" src="{{$product->user->profile->avatar()}}" alt="{{$product->user->profile->firstname}}" width="30px" height="30px">
                        <small>{{$product->user->profile->fullname()}}, {{$product->created_at->diffForHumans()}}</small>
                        @if($product->created_at->diffForHumans() !== $product->updated_at->diffForHumans())
                            <small style="margin-left: 20px"><i class="fa fa-clock"></i>  last updated {{$product->updated_at->diffForHumans()}}</small>                
                        @endif
                    </div>
                    <div class="list-group-item">
                        Shop: <a href="{{route('shop.show',[$product->shop->id])}}">{{$product->shop->name}}</a>
                    </div>
                    <div class="list-group-item">
                        Type : <strong>{{$product->type}}</strong>
                            @if($product->isVariable())
                                <small>
                                    {!!$product->variables()!!}
                                </small>
                            @endif
                        
                    </div>
                    <div class="list-group-item">
                        Category : <small><a href="{{route('categories.show',['id' => $product->category->id])}}">{{$product->category->name}} </a> <span class="badge badge-secondary">{{$product->category->products()->count() > 1 ? $product->category->products()->count() - 1 : 0}}</span> other products</small>
                    </div>
                    
                    <div class="list-group-item">
                        Description:
                        @if($product->description !== null)
                            <small>{{$product->description}}</small>
                            @else
                            <small class="text-danger">No description</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="text-center">
                    <img src="{{$product->preview()}}" alt="{{$product->name}}" width="100%">
                </div>
            </div>
        </div>
        @if(Auth::user()->isAdminOrManager())
            @include('product.widgets.operations')
        @endif
    </div>
</div>
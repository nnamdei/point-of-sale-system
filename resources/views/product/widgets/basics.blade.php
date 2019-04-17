<div class="card">
    <div class="card-header">
        <h6>Info</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="list-group">
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
                        Category : @include('category.templates.category-name',['category' => $product->category_()])
                    </div>
                    
                    <div class="list-group-item">
                        Description:
                        @if($product->description !== null)
                            <small>{{$product->description}}</small>
                            @else
                            <small class="text-danger">No description</small>
                        @endif
                    </div>
                    <div class="list-group-item">
                        <div class="my-1">
                            added {{$product->created_at->toDayDateTimeString()}}, {{$product->created_at->diffForHumans()}}
                        </div>
                        <div class="d-flex">
                            <div class="ml-auto">
                                @include('staff.templates.auth-user-name',['user' => $product->user()])
                            </div>
                        </div>
                        @if($product->created_at->diffForHumans() !== $product->updated_at->diffForHumans())
                            <div class="my-1">last updated {{$product->updated_at->diffForHumans()}}</div>
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
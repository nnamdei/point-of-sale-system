<div class="card">
    <div class="card-header">
        <h6>Info</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div>
                     Added by 
                     <img class="avatar" src="{{$product->user->avatar()}}" alt="{{$product->user->firstname}}" width="40px" height="40px">
                     <small>{{$product->user->fullname()}}, {{$product->created_at->diffForHumans()}}</small>
                    @if($product->created_at->diffForHumans() !== $product->updated_at->diffForHumans())
                        <small style="margin-left: 20px"><i class="fa fa-clock"></i>  last updated {{$product->updated_at->diffForHumans()}}</small>                
                    @endif
                </div>
                <div>
                    Type : <strong>{{$product->type}}</strong>
                        @if($product->isVariable())
                            <small>
                                {!!$product->variables()!!}
                            </small>
                        @endif
                    
                </div>

                <div>
                    Category : <small><a href="{{route('categories.show',['id' => $product->category->id])}}">{{$product->category->name}} </a> <span class="badge badge-secondary">{{$product->category->products->count() - 1}}</span> other products</small>
                </div>
        
                Description:
    
                <div class="description-container">
                    @if($product->description !== null)
                        {{$product->description}}
                        @else
                        <small class="text-warning">No description</small>
                    @endif
                </div>
            </div>
            <div class="col-sm-4">
                <div class="text-center">
                    <img src="{{$product->preview()}}" alt="{{$product->name}}" width="100%">
                </div>
            </div>
        </div>
        @if(Auth::user()->isManager())
            @include('products.templates.operations')
        @endif
    </div>
</div>
    <div class="card">
            <div class="card-header">
                <h6>Info</h6>
            </div>
            <div class="card-body">
                <div>
                    <small class="grey"><i class="fa fa-user"></i> added by {{$product->user->fullname()}} {{$product->created_at->diffForHumans()}}</small>
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
                    <small>Category : <a href="{{route('categories.show',['id' => $product->category->id])}}">{{$product->category->name}} </a> <span class="badge badge-secondary">{{$product->category->products->count() - 1}}</span> other products</small>
                </div>
                
                <small>Description:</small>
            
                <div class="description-container">
                    @if($product->description !== null)
                        {{$product->description}}
                        @else
                        <small class="text-warning">No description</small>
                    @endif
                </div>
            </div>
        </div>

<div class="container py-2 mt-2" style="background-color: transparent">
        @foreach($categories as $cat)
        <div class="card">
            <div class="card-header text-center">
                {{$cat->name}}
            </div>
            <div class="card-body grid px-3">
                @foreach ($cat->brands as $b)
                @forelse($b->products as $product)
                <div class="product">
                    <div class="image mb-2">
                        <img src="{{asset('/storage/'.$product->images[0])}}" 
                        alt="">
                    </div>
                    <div class="content text-center">
                        <div class="title">
                            <h3>{{$product->name}}</h3>
                        </div>
                    </div>
                    <div class="product-footer p-2">
                            <a href="{{route('user.product.detail',[$product->id])}}">more details</a>
                            @if (Cart::get($product->id))
                                <div class="incard text-primary">
                                    in card
                                </div>
                            @else
                            @if ($product->available_quantity > 0)
                            <form action="" wire:submit.prevent="addToCard({{$product->id}})" method="post">
                                <button class="btn btn-sm btn-outline-primary" type="submit">add to card</button>
                            </form>
                            @else
                                <div class="text-danger">not in stoke</div>
                            @endif
                            @endif
                    </div>
                </div>
                @empty
                <p style="font-size: 21px;
                margin-top: 20px;">no products</p>
                
                @endforelse
                
                @endforeach

            </div>
                <div class="no-grid mb-3" @if($cat->brands->first()->products_count > 1) style="place-self: center"@endif>
                    <a class="ml-2" style="margin: 5px;text-decoration: none;margin-left: 10px" href="{{route('user.category.detail',[$cat->id])}}">see more</a>
                </div>
        </div>
        @endforeach
</div>

<div>
    <h2 class="blue text-center mt-2">{{$category->name}}</h2>
    <div class="row m-2 p-2 gap-2" style="justify-content: center;">
        <div class="col-12 col-md-3 card mb-2 p-0">
            <div class="card-header">filters</div>
            <div class="card-body">
                @foreach ($categoryFilter->brands as $b)
                <input type="checkbox" name="brand_filter" wire:model="brandFilter"
                 id="brands{{$b->id}}" value="{{$b->id}}">
                <label for="brands{{$b->id}}">{{$b->name}}</label>
                 [{{isset($brands_count[$b->id]) && $brands_count[$b->id] > 0?$brands_count[$b->id]: 0}}] <br>
                @endforeach  
                <hr>
                <select name="" id="" class="form-control" wire:model="orderType">
                    @foreach ($AllowOrderTypes as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                    </select>
                <div class="row">
                    <div class="col-6">
                        min: <br><input min="0" class="form-control" wire:model="min" type="number" name="" id="">
                    </div>
                    <div class="col-6">
                        max: <br><input min="0" class="form-control" wire:model="max" type="number" name="" id="">
                    </div>
                    
                </div>
            </div>  
                    
        </div>
        <div class="col-12 col-md-8 mb-2 p-0">
                @foreach ($category->brands as $b)
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="name">{{$b->name}}</div>
                        <div>show <span class="blue">[{{$product_count_exists}}]</span> from
                        <span class="blue">{{$products_count}}</span></div>
                    </div>
                    <div class="card-body grid px-2">
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
                        <div class="row">
                            <div class="col-6">price: {{$product->price}}</div>
                            <div class="col-6">available {{$product->available_quantity}}</div>
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
                no products
                @endforelse
                    </div>
                </div>
                @endforeach
                @if ($products_count > $product_count_exists)
                <button class="btn btn-primary no-grid" style="max-width: 100px;"
                 wire:click="loadMore">load more</button>
                @endif
            </div>
        </div>
    </div>
<div>
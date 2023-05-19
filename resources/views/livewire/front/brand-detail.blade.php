<div class="row m-2 p-2" style="justify-content: center;">
        @if ($brand->products_count > 0)
        <div class="col-3 card p-0" style="margin-right: 10px">
            <div class="card-header">filters</div>
            @if ($min > 0 || $max > 0)
                <button class="btn btn-outline-primary w-50 m-3" 
                wire:click="resetFilters">reset filters</button>
            @endif
            <div class="card-body">
                <select name="" id="" class="form-control" wire:model="orderType">
                @foreach ($AllowOrderTypes as $type)
                    <option value="{{$type}}">{{$type}}</option>
                @endforeach
                </select>
                <hr>
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
        @endif
        <div class="card col-8 p-0">
            <div class="card-header text-center">
                {{$brand->name}} show <span class="blue">[{{count($brand->products)}}]</span>
                 from <span class="blue">[{{$brand->products_count}}]</span>
            </div>
            <div class="card-body grid px-3">
                @forelse($brand->products as $product)
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
                            <form wire:loading.remove wire:target="addToCard({{$product->id}})" action="" wire:submit.prevent="addToCard({{$product->id}})" method="post">
                                <button  class="btn btn-sm btn-outline-primary"
                                 type="submit">add to card</button>
                            </form>
                            <div wire:loading wire:target="addToCard({{$product->id}})"
                                style="width: 27px;height: 27px;"
                                 class="spinner-border text-primary number" role="status">
                            </div>
                            @else
                                <div class="text-danger">not in stoke</div>
                            @endif
                            @endif
                    </div>
                </div>
                @empty
                no products
                @endforelse
                @if ($brand->products_count > count($brand->products))
                <button class="btn btn-primary no-grid" style="max-width: 100px;"
                 wire:click="loadMore">load more</button>
                @endif
            </div>
        </div>
    </div>

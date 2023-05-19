<div>
    <div class="p-3 m-3 h-100 card">
     <div class="row">
        <div class="col-sm-5 col-12" style="border-right: 1px solid lightgrey">
            <figure>
                <img class="w-100" style="max-height: 350px" src="{{asset('/storage/'.$product->images[0])}}" alt="">
                <caption>
                    <h3 class="blue text-center">{{$product->name}}</h3>
                </caption>
            </figure>
        </div>
        <div class="col-sm-7 col-12 product-detail">
            <div class="col-sm-12">
                <h2 class="blue text-center">{{$product->name}}</h2>
                <p>{{$product->small_description}}</p>   
            </div>
            <div class="col-12">
                @if ($product->available_quantity > 0)
                @if (Cart::get($product->id))
                <h4 class="text-success">in card</h4>
            @else
            <form action="" wire:submit.prevent="addToCard({{$product->id}})" method="post">
                <div class="gap-2 mb-2" style="display: flex">
                <input class="form-control w-25" min="1"
                 max="{{$product->available_quantity}}" type="number"
                 name="q" id="q" wire:model.defer="quantity">
                <button class="btn btn-outline-primary" type="submit">add to cart</button>
                </div>
                @error('quantity')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </form>
            @endif
                @else
                    <h4 class="text-danger">not in stock</h4>
                @endif
            </div>
        </div>
        <div class="col-12" style="border-top: 1px solid lightgrey">
            <h2 class="blue text-center">description</h2>
            <p>{{$product->description}}</p>
        </div>
    </div>       
    </div>

</div>

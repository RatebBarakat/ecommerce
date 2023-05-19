<div class="cart-detail">
    <div style="width: fit-content;border-left: 1px solid lightgrey">
      <li id="cardDisplay" style="text-align: end;list-style: none;position: relative;"
       class="list-item px-4 dropdown dropleft" id="dropdownMenuButton" 
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <span wire:loading.remove class="number">{{count(Cart::getContent())}}</span>
            <div wire:loading class="spinner-border spinner-border-sm text-primary number" role="status">
              </div>
      </li>
      <div class="dropdown-menu dropleft" style="right: 0 !important"
       aria-labelledby="dropdownMenuButton">
        @forelse ($cards as $cart)
            <li class="dropdown-list">
                <div>{{$cart->name}}</div>
                <div>total price : {{$cart->quantity * $cart->price}}</div>
                <div>
                    <form action="" method="post" wire:submit.prevent="deleteCard({{$cart->id}})">
                        <button
                             class="btn btn-sm btn-outline-danger">delete
                        </button>
                    </form>
                </div>
            </li>
            @empty
            <div class="px-2">
                <p class="w-100 mb-0">you card is empty</p> <br>
                <button class="btn btn-outline-success m-auto w-100"
                 onclick="$(#dropdownMenuButton).dropdown('toggle')"
                >continue shoping</button>
            </div>
        @endforelse
      </div>
      {{-- <div id="cardList" class="p-0">
  
          <ul style="padding: 0 !important;margin-bottom: 0" class="content">
              @forelse (Cart::getContent() as $card)
                      <li>
                      <span id="card-container" style="width: 100%;height: 100%" wire:loading.remove wire:target="delete({{$card->id}})">
                      <span>{{$card['name']}}</span>
                      <span>Price:{{$card['price']}}</span>
                      <span>quantity:{{$card['quantity']}}</span>
                      <span>
                          <button wire:click="delete({{$card['id']}})"
                          class="btn btn-outline-danger btn-sm">remove</button>
                      </span>
                      </span>
                      <div style="position: relative;left: 43%;"
                          wire:loading wire:target="delete({{$card->id}})"
                          class="spinner-border text-primary" role="status">
                      </div>
                      </li>
              
                  @empty
                  <span style="font-size: 18px;
                  color: black;
                  padding: 10px 0;
                  text-align: center;
                  width: 100%;
                  display: block;">you card is emty</span>
              @endforelse
                      @if(count(Cart::getContent()) > 0)
                      <li><a class="btn btn-outline-primary btn-sm float-end" href="/card">card</a></li>
                      @endif
          </ul>
      </div> --}}
  </div>
  
  </div>

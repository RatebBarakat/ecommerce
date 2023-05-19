<div class="container-lg m-auto py-3 mt-3">
    <div class="row">
        <div class="col-md-8">
            <form class="row" action="" wire:submit.prevent="checkout">
                <div class="col-12 bg-white">
                    <h2 class="title text-center blue">billing address</h2>
                    <div class="form-group">
                        <label for="first_name">first name</label>
                        <input type="text" id="first_name" value="{{auth('admin')->user()->name}}"
                               wire:model.defer="addr.billing.first_name"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="first_name">last name</label>
                        <input type="text" id="first_name" wire:model.defer="addr.billing.last_name"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="first_name">email</label>
                        <input type="email" id="first_name" wire:model.defer="addr.billing.email"
                               class="form-control">
                    </div>
                </div>
                <div class="col-12">

                </div>
            </form>
        </div>
        <div class="col">
            <div class="card p-0">
                <div class="card-header">
                    cart detail
                </div>
                <div class="card-body">
                    <ul class="list-group">
                    @foreach(Cart::getContent() as $c)
                        <li class="list-group-item border-0 p-1 m-1">
                            <span style="min-width: 30%;display: inline-block;text-align: center">{{$c->name}}</span>
                            <span style="min-width: 30%;display: inline-block;text-align: center">{{$c->price}}</span>
                            <span style="min-width: 30%;display: inline-block;text-align: center">{{$c->quantity}}</span>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

namespace App\Http\Livewire\Front;

use App\Models\Order;
use App\Models\OrderProduct;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Cart;
class Checkout extends Component
{
    public string $email;
    public string $payment;
    public string $status;
    public string $payment_mode;
    public $addr = ['billing' => [
        'first_name' => null,
        'last_name' => null,
        'address' => null,
    ],
    'shipping' => [
        'first_name' => null,
        'last_name' => null,
        'address' => null,
    ]];
    public bool $sameShipingBilling = false;
    public function render()
    {
        if ($this->sameShipingBilling == true) {
            $this->addr['shipping'] = $this->addr['billing'];
        }
        return view('livewire.front.checkout',
            ['carts' => Cart::getContent()]);
    }
    public function store()
    {
            $this->validate([
                'payment_mode' => 'required',
                'addr.billing.first_name' => 'required|min:2|max:20',
                'addr.billing.last_name' => 'required|min:2|max:20',
                'addr.billing.address' => 'required|min:4|max:30',
                'addr.billing.email' => 'required|email|unique:users,email|unique:admins,email',
                'addr.shipping.first_name' => 'required|min:2|max:20',
                'addr.shipping.last_name' => 'required|min:2|max:20',
                'addr.shipping.address' => 'required|min:4|max:30',
                'addr.shipping.email' => 'required|email|unique:users,email|unique:admins,email',
            ]
                ,[
                'addr.billing.first_name.required' => 'the first name field is required',
                'addr.billing.first_name.min' => 'the first must be more than 2',
                'addr.billing.first_name.max' => 'the first must be less than 20',
                'addr.billing.last_name.required' => 'the last name field is required',
                'addr.billing.last_name.min' => 'the last must be more than 2',
                'addr.billing.last_name.max' => 'the last must be less than 20',
                'addr.billing.address.required' => 'the adress field is required',
                'addr.billing.address.min' => 'the last must be more than 4',
                'addr.billing.address.max' => 'the last must be less than 30',
                'addr.billing.email.required' => 'the email name field is required',
                'addr.billing.email.email' => 'the email must be an email',
                'addr.billing.email.unique' => 'the email must be unique',
            ]);


        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'payment' => $this->payment,
                'payment_mode' => $this->payment_mode,
                'status' => $this->status
            ]);
            foreach (Cart::getContent() as $cart) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $order->id,
                    'name' => $cart->name,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity
                ]);
            }
            foreach ($this->addr as $type => $address) {
                $address['type'] = $type;
                $order->addresses()->create([
                    'type' => $type,
                    'first_name' => $address['first_name'],
                    'last_name' => $address['last_name'],
                    'email' => $address['email'],
                    'phone_number' => $address['phone_number'],
                    'street_address' => $address['street_address'],
                    'postal_code' => $address['postal_code'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                    'order_id' => $order->id
                ]);
                Db::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }

    }
}

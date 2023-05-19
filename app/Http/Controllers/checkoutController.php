<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class checkoutController extends Controller
{
    public function create()
    {
        if (count(Cart::getContent()) <= 0) {
            return redirect('/')->with('error','your cart is empty');
        }
        return view('front.checkout',[
            'carts' => Cart::getContent(),
            'countries' => [
                'lebanon',
                'syria',
                'jordan',
            ]
        ]);
    }
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'addr.billing.first_name' => 'required|min:2|max:20',
            'addr.billing.last_name' => 'required|min:2|max:20',
            'addr.billing.email' => 'required|email|unique:users,email|unique:admins,email',
            'addr.billing.address' => 'required|min:4|max:30',
        ],
            [
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
        $v->safe();
        if ($v->fails()) {
            return back()->withInput();
        }
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->user()->id,
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
            foreach ($request->post('addr') as $type => $address) {
                $address['type'] = $type;
                $order->addresses()->create($address->validated());
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        Db::commit();

    }
}

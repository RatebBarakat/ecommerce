<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\Product;
use Cart;
class ProductDetail extends Component
{
    protected $listeners = ['cardUpdated' => 'render'];
    public Product $product;
    public int $quantity = 1;
    public function mount($product)
    {
        $this->product = $product;
    }
    public function render()
    {
        return view('livewire.front.product-detail');
    }
    public function addToCard(int $product_id)
    {

        $product = Product::findOrFail($product_id);
        $this->validate([
            'quantity' => "required|min:1|max:$product->available_quantity"
        ]);
        if ($product->available_quantity > 0) {
            if (!Cart::get($product->id)) {
                Cart::add(array(
                    "id" => $product->id, // inique row ID
                    "name" => $product->name,
                    "price" => $product->price,
                    "quantity" => $this->quantity,
                ));
                $this->emit('cardUpdated');
                $this->dispatchBrowserEvent('alert',[
                    'type' => 'success',
                    'message' => 'product added to cart'
                ]);
            } else {
                Cart::update(456, array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $this->quantity > $product->available_quantity ? 
                        $product->available_quantity : $this->quantity
                    ),
                  ));
                $this->dispatchBrowserEvent('alert',[
                    'type' => 'success',
                    'message' => 'product quantity'. $this->quantity .' updated suucessfully'
                ]);
            }
            
        } else {
            $this->dispatchBrowserEvent('alert',[
                'type' => 'error',
                'message' => 'product quantity is 0'
            ]);
        }
        
    }
}

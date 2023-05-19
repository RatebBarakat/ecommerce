<?php

namespace App\Http\Livewire\Front;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Cart;

class Home extends Component
{
    protected $listeners = ['cardUpdated' => 'render'];
    public $categoriesAll;
    public $inCard = [];
    public function mount($categoriesAll)
    {
        $this->categoriesAll = $categoriesAll;
    }
    public function render()
    {
        // $cards = Cart::getContent();
        // foreach ($cards as $card) {
        //     Cart::remove($card->id);
        // }
        // foreach ($cards as $card) {
        //     array_push($this->inCard,$card->id);
        // }
        $categories = Category::Has('brands.products')
        ->with(['brands' => function ($q)
    {
        $q->whereHas('products')->withCount('products')->take(2);
    },'brands.products' => function ($q)
    {
        $q->take(3);
    }])->withCount('brands')->latest()->take(5)
        ->where('visibility',1)->get();
        return view('livewire.front.home',[
            'categoriesAll' => $this->categoriesAll,
            'categories' => $categories
        ]);
    }
    public function addToCard(int $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->available_quantity > 0) {
            Cart::add(array(
                "id" => $product->id, // inique row ID
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
            ));
            $this->emit('cardUpdated');
            $this->dispatchBrowserEvent('alert',[
                'type' => 'success',
                'message' => 'product added to cart'
            ]);
        } else {
            $this->dispatchBrowserEvent('alert',[
                'type' => 'error',
                'message' => 'product quantity is 0'
            ]);
        }
        
    }
}

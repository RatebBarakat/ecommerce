<?php

namespace App\Http\Livewire\Front;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Product;
use Cart;
class BrandDetail extends Component
{
    protected $listeners = ['cardUpdated' => 'render','removeFilter'];
    public int $brand_id;
    public string $orderType = 'descending';
    public $min = null;
    public $max = null;
    public $filters = ['min','max'];
    public $AllowOrderTypes = [
        'descending',
        'asending',
        'price high to low',
        'price low to high',
    ];
    public int $perPage = 10;
    public function mount(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }
    public function render()
    {
        $brand = Brand::with(['products' => function ($q)
        {
            $q->when(($this->min > 0 || $this->max > 0),
            function ($q)
            {
                if($this->min > 0){
                    $q->where('price','>=',$this->min);
                }
                if($this->max > 0){
                    $q->where('price','<=',$this->max);
                }
            })
            ->when(in_array($this->orderType,$this->AllowOrderTypes),function ($q)
            {
                switch ($this->orderType) {
                    case 'descending':
                        $q->latest('id');
                        break;
                    case 'asending':
                        $q->orderBy('id','asc');
                        break;
                    case 'price high to low':
                        $q->orderBy('price','desc');
                        break;
                    case 'price low to high':
                        $q->orderBy('price','asc');
                        break;
                }
            })
            ->take($this->perPage);
        },'category'])->withCount(['products' => function ($q)
        {
            $q->when(($this->min > 0 || $this->max > 0),
            function ($q)
            {
                if($this->min > 0){
                    $q->where('price','>=',$this->min);
                }
                if($this->max > 0){
                    $q->where('price','<=',$this->max);
                }
            });
        }])->findOrFail($this->brand_id);
        $this->brand = $brand;
        return view('livewire.front.brand-detail',compact('brand'));
    }
    public function loadMore()
    {
        $this->perPage += 30;
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
    public function resetMin()
    {
        $this->min = null;
    }
    public function resetFilters()
    {
        $this->min = null;
        $this->max = null;
    }
    public function removeFilter($filter)
    {
        dd($filter);
        $this->reset([$filter]);
    }
}

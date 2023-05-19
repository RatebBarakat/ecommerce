<?php

namespace App\Http\Livewire\Front;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use Cart;
use Livewire\WithPagination;

class CategoryDetail extends Component
{
    use WithPagination;
    protected $listeners = ['cardUpdated' => 'render'];
    public int $perPage = 3;
    public int $category_id;
    public $brandFilter = [];
    public string $orderType = 'descending';
    public $min = null;
    public $max = null;
    public $brands_count = []; 
    public $filters = ['min','max'];
    public $AllowOrderTypes = [
        'descending',
        'asending',
        'price high to low',
        'price low to high',
    ];
    public function mount(int $category_id)
    {
        $this->category_id = $category_id;
    }
    public function loadMore()
    {
        $this->perPage += 30;
    }
    public function render()
    {
        $categoryFilter = Category::whereHas('brands')->with(['brands' => function ($q)
        {   
            $q->whereHas('products')->withCount(['products' => function ($q)
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
            }]);
        }])
        ->findOrFail($this->category_id,['id','name']);
        $available_brands = [];
        foreach ($categoryFilter->brands as $b) {
            array_push($available_brands,$b->id);
        }
        $category = Category::whereHas('brands.products')->with(['brands' => function ($q)
        {
            $q->whereHas('products')->with(['products' => function ($q)
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
                })->when(in_array($this->orderType,$this->AllowOrderTypes),function ($q)
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
            }])->when(count($this->brandFilter) > 0,function($q){
                foreach ($this->brandFilter as $b) {
                    Brand::findOr($b,function ()
                    {
                        return redirect('/');
                    });
                }
                $q->whereIn('id',$this->brandFilter);
            });
        }])->findOrFail($this->category_id);
        $categories_count = [];
        foreach ($categoryFilter->brands as $b) {
            array_push($categories_count,$b->id);
        }

        foreach ($categoryFilter->brands as $b) {
            $this->brands_count[$b->id] = $b->products_count;
        }
        $products_count = 0;
        $product_count_exists = 0;
        if (count($this->brandFilter) > 0) {
            foreach ($categoryFilter->brands as $c) {
                if (in_array($c->id,$this->brandFilter)) {
                    $products_count += $c->products_count;
                }
            }
        } else {
            foreach ($categoryFilter->brands as $c) {
                $products_count += $c->products_count;
            }            
        }
        
        foreach ($category->brands as $c) {
            $product_count_exists += count($c->products);
        }
        $brands_count = [];
        $brands_count = $this->brands_count;

        return view('livewire.front.category-detail',
        compact('category','categoryFilter','products_count','product_count_exists',"brands_count"));
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

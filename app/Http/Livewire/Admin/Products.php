<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public int $per_page = 10;
    public $search = null;
    public $name = null;
    public $small_description = null;
    public $description = null;
    public $images = [];
    public $admin_id = null;
    public $category_id = null;
    public $brand_id = null;
    public $product_id = null;
    public $with_deleted = "off";
    public int $price = 1;
    public int $discount = 0;
    public int $categoruFilter;
    public $brandsFilter = [];
    public $add_mode= false;
    public $categories_counts = [];
    public int $available_quantity = 1;
    public function resetPagination()
    {
        $this->resetPage();
    }
    public function resetInputs()
    {
        $this->name = null;
        $this->small_description = null;
        $this->description = null;
        $this->price = 1;
        $this->available_quantity = 1;
        $this->discount = 0;
        $this->admin_id = null;
        $this->category_id = null;
        $this->brand_id = null;
        $this->images = [];
    }
    public function filteringData()
    {
        if (strlen($this->search) > 0) {
            $this->resetPage();
        }
    }
    public function render()
    {
        if ($this->category_id == null) {
            $this->brandsFilter = [];
        }
        $brands = null;
        if (!is_null($this->category_id) && $this->category_id != null) {
            $category = Category::findOrFail($this->category_id);
            $brands = Brand::query();
            $brands->whereBelongsTo($category);
            // $this->brandsFilter = [];
            // foreach ($brands->get()->toArray() as $b) {
            //     array_push($this->brandsFilter,$b['id']);
            // }
        }
        $categories = Category::with(['brands' => function ($q)
        {
            $q->withCount('products');
        }])->get(['id','name']);

        $products = Product::when($this->with_deleted == 'on',function ($q)
        {
            $q->withTrashed();
        })->when((count($this->brandsFilter) > 0),function ($q)
        {
            $q->whereIn('brand_id',$this->brandsFilter);
            // foreach ($this->brandsFilter as $b) {
            //     $q->whereBelongsTo(Brand::findOrFail($b));
            // }
        })
        ->when(!is_null($this->search),function ($q)
        {
            $q->where('name','like','%'.$this->search.'%')
            ->orWhere('description','like','%'.$this->search.'%');
        })->paginate(is_int($this->per_page) ? abs($this->per_page): 10);
        $categories_counts = [];
        foreach ($categories as $cat) {
            array_push($categories_counts,$cat->id);
        }
        foreach ($categories as $cat) {
            $count = 0;
            foreach ($cat->brands as $b) {
                $count+=$b->products_count;
            }
        $this->categories_counts[$cat->id] = $count;
        }


        return view('livewire.admin.products',[
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands == null ? null: $brands->get(),
            'brandsFilters' => $brands == null ? null: $brands->get(),
            'categories_count' => $this->categories_counts
        ]);
    }
    public function showAddModal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetInputs();
        $this->emit('open_add_modal');
    }
    public function closeAddModal()
    {
        $this->resetInputs();
        $this->emit('close_add_modal');
    }
    public function restoreProduct(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => $product->name. " has restored successfully"
        ]);
    }
    public function addProduct()
    {
        $this->validate([
            'name' => 'required',
            'small_description' => 'required|min:50|max:250',
            'description' => 'required|min:200',
            'price' => 'required|integer|min:0',
            'available_quantity' => 'required|integer|min:0|max:100',
            'images' => 'required',
            'images.*' => 'image|mimes:png,jpg',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
        ]);

        foreach ($this->images as $key => $image) {
            $this->images[$key] = $image->store('images','public');
        }
    
        $this->images = array_values($this->images);
        Product::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'small_description' => $this->small_description,
            'description' => $this->description,
            'images' => $this->images,
            'price' => $this->price,
            'available_quantity' => $this->available_quantity,
            'admin_id' => auth()->guard('admin')->user()->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Product added succesfully']);
        $this->emit('addProduct');
        $this->resetErrorBag();
        $this->resetValidation();

    }
    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => $product->name.' deleted successfully'
        ]);
    }
    public function deleteProductForce(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        if (!empty($product->images)) {
            try {
                foreach ($product->images as $key => $image) {
                    unlink('storage/'.$image);
                }
            } catch (\Throwable $th) {
                abort(500);
            }
        }
        $product->forceDelete();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => $product->name.' deleted totally successfully'
        ]);
    }
}

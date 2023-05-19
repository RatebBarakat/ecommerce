<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $slug;
    public $category_id;
    public $ads = 1;
    public int $brandsCount;
    public int $perPage = 10;
    public $search = null;
    public $categoryFilter = null;

    public function render()
    {
        $brands = Brand::query();
        if (!empty($this->categoryFilter)) {
            $brands->whereBelongsTo(Category::findOrFail($this->categoryFilter));
        }
        if (!empty($this->search)) {
            $brands->where('name','like','%'.$this->search.'%');
                }
        $categories = Category::get(['id','name']);
        return view('livewire.admin.brands',[
            'brands' => $brands->paginate(abs($this->perPage)),
            'categories' => $categories,
        ]);
    }
    public function resetInputs(){
        $this->name = null;
        $this->category_id = null;
        $this->search = null;
    }
    public function filteringData()
    {
        if (strlen($this->search) > 0) {
            $this->resetPage();
        }
    }
    public function showAddModal()
    {
        $this->resetInputs();
        $this->emit('openAddModal');
    }
    public function closeAddModal()
    {
        $this->resetInputs();
        $this->emit('closeAddModal');
    }
    public function addBrand()
    {
        $this->validate([
            'name' => 'required|unique:brands|min:2',
            'category_id' => 'required'
        ]);
        Category::findOrFail($this->category_id);
        Brand::create([
            'name' => $this->name,
            'category_id' => $this->category_id
        ]);
        $this->resetInputs();
        $this->emit('closeAddModal');
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => 'Brand added succesfuly'
        ]);
    }
    public function deletebrand(int $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => 'Brand deleted succesfuly'
        ]);
    }
}

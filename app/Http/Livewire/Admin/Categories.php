<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $slug;
    public $visibility = 1;
    public $ads = 1;
    public int $categoriesCount;
    public int $perPage = 10;
    public $search = null;

    public function render()
    {
        if (empty($this->search)) {
            $categories = Category::paginate(abs($this->perPage));
        } else {
            $categories = Category::where(function ($q)
            {
                $q->where('name','like','%'.$this->search.'%')
                ->orWhere('slug','like','%'.$this->search.'%');
            })
            ->paginate(abs($this->perPage));
        }
        return view('livewire.admin.categories',[
            'categories' => $categories,
        ]);
    }
    public function resetInputs(){
        $this->name = null;
        $this->slug = null;
        $this->visibility = 1;
        $this->ads = 1;
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
    public function addCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories|min:2',
        ]);
        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'visibility' => $this->visibility,
            'ads' => $this->ads,
        ]);
        $this->resetInputs();
        $this->emit('closeAddModal');
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => 'category added succesfuly'
        ]);
    }
    public function deleteCategory(int $id)
    {
        $brand = Category::findOrFail($id);
        $brand->delete();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => 'category deleted succesfuly'
        ]);
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class BrandEdit extends Component
{
    public $brand;
    public $name = null;
    public $category_id;
    public function mount(Brand $brand)
    {
        $this->brand = $brand;
        $this->name = $brand->name;
        $this->category_id = $brand->category->id;
    }
    public function render()
    {
        return view('livewire.admin.Brand-edit',[
            'Brand' => $this->brand,
            'categories' => Category::all()
        ]);
    }
    public function updateBrand(int $id){
        $validatedata = $this->validate([
            'name' => 'required|min:2',
            'category_id' => 'required',
        ]);
        $category = Category::findOrFail($this->category_id);
        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
        ]);
        session()->flash('edit_success','Brand updated successfully');
        return redirect()->route('admin.brands');
    }
}

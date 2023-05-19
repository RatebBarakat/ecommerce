<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class CategoryEdit extends Component
{
    public $category;
    public $name = null;
    public $slug = null;
    public $visibility = null;
    public $ads = null;
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->visibility = $category->visibility;
        $this->ads = $category->ads;
    }
    public function render()
    {
        return view('livewire.admin.category-edit',[
            'category' => $this->category
        ]);
    }
    public function updateCategory(int $id){
        $category = Category::findOrFail($id);
        $validatedata = $this->validate([
            'name' => 'required|min:2',
            'visibility' => 'required',
            'ads' => 'required',
        ]);
        $category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'visibility' => $this->visibility,
            'ads' => $this->ads,
        ]);
        session()->flash('edit_success','category updated successfully');
        return redirect()->route('admin.categories');
    }
}

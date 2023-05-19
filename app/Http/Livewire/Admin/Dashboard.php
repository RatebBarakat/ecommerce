<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;

class Dashboard extends Component
{
    public function render()
    {
        $users = User::count();
        $admins = Admin::count();
        $categories = Category::count();
        $products = Product::count();
        return view('livewire.admin.dashboard',compact('users','admins','categories','products'));
    }
}

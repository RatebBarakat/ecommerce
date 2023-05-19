<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(int $id)
    {
        $category = Category::findOrFail($id);
        return view('front.category-detail',[
            'category' => $category
        ]);
    }
}

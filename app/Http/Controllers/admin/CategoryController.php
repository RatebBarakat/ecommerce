<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function edit(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return view('admin.category-edit',compact('category'));
    }
}

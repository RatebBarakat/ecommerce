<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function edit(Request $request)
    {
        $brand = Brand::with('category')->findOrFail($request->id);
        return view('admin.brand-edit',compact('brand'));
    }
}

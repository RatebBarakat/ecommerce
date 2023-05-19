<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(int $id)
    {
        $brand = Brand::findOrFail($id);
        return view('front.brand-detail',compact('brand'));
    }
}

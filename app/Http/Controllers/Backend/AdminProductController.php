<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function AdminAllProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.product.all_product', compact('product'));
    }
    // End Method
}
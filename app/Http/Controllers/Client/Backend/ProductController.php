<?php

namespace App\Http\Controllers\Client\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\Product;


class ProductController extends Controller
{
    public function AllProduct()
    {
        $product = Product::latest()->get();
        return view('client.backend.product.all_product', compact('product'));
    } // End Method

    public function AddProduct()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        return view('client.backend.product.add_product', compact('category', 'city', 'menu'));
    } // End Method

    public function StoreProduct() {
        
    } // End Method 
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Menu;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function AdminAllProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.product.all_product', compact('product'));
    } // End Method

    public function AdminAddProduct()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        return view('admin.backend.product.add_product', compact('category', 'city', 'menu', 'client'));
    } // End Method

    public function AdminChangeStatus(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success' => 'Status Change Successfully']);
    } // End Method
}

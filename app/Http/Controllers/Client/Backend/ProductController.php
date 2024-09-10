<?php

namespace App\Http\Controllers\Client\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

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

    public function StoreProduct(Request $request)
    {
        $pcode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 5, 'prefix' => 'FO']);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/product/' . $name_gen;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'code' => $pcode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => Auth::guard('client')->id(),
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);

            $img->resize(300, 300)->save(public_path($save_url));
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    } // End Method

    public function EditProduct($id)
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $product = Product::find($id);
        return view('client.backend.product.edit_product', compact('category', 'city', 'menu', 'product'));
    } // End Method
}

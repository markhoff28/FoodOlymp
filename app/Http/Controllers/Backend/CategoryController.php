<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    } // End Method

    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
    } // End Method

    public function StoreCategory(Request $request)
    {

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/category/' . $name_gen));
            $save_url = 'upload/category/' . $name_gen;

            Category::create([
                'category_name' => $request->category_name,
                'category_image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
    } // End Method

    public function EditCategory($id)
    {
        $category = Category::find($id);
        return view('admin.backend.category.edit_category', compact('category'));
    } // End Method 

    public function UpdateCategory(Request $request)
    {
        $cat_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/category/' . $name_gen));
            $save_url = 'upload/category/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        } else {

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
            ]);
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        }
    } // End Method

    public function DeleteCategory($id)
    {
        $item = Category::find($id);
        $img = $item->category_image;
        unlink($img);

        Category::find($id)->delete();

        $notification = array(
            'message' => 'Category Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
}

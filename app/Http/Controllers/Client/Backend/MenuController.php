<?php

namespace App\Http\Controllers\Client\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;

class MenuController extends Controller
{
    public function AllMenu()
    {
        $menu = Menu::latest()->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    } // End Method

    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    } // End Method

    public function StoreMenu(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::create([
                'menu_name' => $request->menu_name,
                'menu_image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Menu Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.menu')->with($notification);
    } // End Method

    public function EditMenu($id)
    {
        $menu = Menu::find($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    } // End Method

    public function UpdateMenu(Request $request)
    {
        $menu_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
                'menu_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);
        } else {

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);
        }
    } // End Method

    public function DeleteMenu($id)
    {
        $item = Menu::find($id);
        $img = $item->menu_image;
        unlink($img);

        Menu::find($id)->delete();

        $notification = array(
            'message' => 'Menu Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
}

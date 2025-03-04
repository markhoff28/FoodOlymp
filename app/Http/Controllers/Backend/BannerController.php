<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Banner;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banner = Banner::latest()->get();
        return view('admin.backend.banner.all_banner', compact('banner'));
    } // End Method

    public function BannerStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $name_gen));
            $save_url = 'upload/banner/' . $name_gen;

            Banner::create([
                'banner_url' => $request->url,
                'banner_image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method

    public function EditBanner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->banner_image = asset($banner->banner_image);
        }
        return response()->json($banner);
    } // End Method

    public function BannerUpdate(Request $request)
    {
        $banner_id = $request->banner_id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $name_gen));
            $save_url = 'upload/banner/' . $name_gen;

            Banner::find($banner_id)->update([
                'banner_url' => $request->url,
                'banner_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        } else {

            Banner::find($banner_id)->update([
                'banner_url' => $request->url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        }
    } // End Method 

    public function DeleteBanner($id)
    {
        $item = Banner::find($id);
        $img = $item->banner_image;
        unlink($img);

        Banner::find($id)->delete();

        $notification = array(
            'message' => 'Banner Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
}

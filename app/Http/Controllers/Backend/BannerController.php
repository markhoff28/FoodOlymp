<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banner = Banner::latest()->get();
        return view('admin.backend.banner.all_banner', compact('banner'));
    } // End Method
}

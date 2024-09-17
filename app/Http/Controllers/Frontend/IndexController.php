<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class IndexController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
    } // End Method

    public function RestaurantDetails($id)
    {
        $client = Client::find($id);
        return view('frontend.details_page', compact('client'));
    }
    //End Method
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Menu;

class IndexController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
    } // End Method

    public function RestaurantDetails($id)
    {
        $client = Client::find($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $gallerys = Gallery::where('client_id', $id)->get();
        $reviews = Review::where('client_id', $client->id)->where('status', 1)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);

        $ratingCounts = [
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count(),
        ];
        $ratingPercentages =  array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);
        return view('frontend.details_page', compact('client', 'menus', 'gallerys', 'reviews', 'roundedAverageRating', 'totalReviews', 'ratingCounts', 'ratingPercentages'));
    }
    //End Method
}

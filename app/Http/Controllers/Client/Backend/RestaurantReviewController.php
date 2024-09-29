<?php

namespace App\Http\Controllers\Client\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class RestaurantReviewController extends Controller
{
    public function ClientAllReviews()
    {
        $id = Auth::guard('client')->id();
        $allreviews = Review::where('status', 1)->where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.review.view_all_review', compact('allreviews'));
    }
    // End Method 
}

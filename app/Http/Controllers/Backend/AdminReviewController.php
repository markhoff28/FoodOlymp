<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;

class AdminReviewController extends Controller
{
    public function AdminPendingReview()
    {
        $pedingReview = Review::where('status', 0)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_pending_review', compact('pedingReview'));
    }
    // End Method 
    public function AdminApproveReview()
    {
        $approveReview = Review::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_approve_review', compact('approveReview'));
    }
    // End Method
}

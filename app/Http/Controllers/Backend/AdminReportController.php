<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use DateTime;

class AdminReportController extends Controller
{
    public function AminAllReports()
    {
        return view('admin.backend.report.all_report');
    } // End Method

    public function AminSearchByDate(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orderDate = Order::where('order_date', $formatDate)->latest()->get();
        return view('admin.backend.report.search_by_date', compact('orderDate', 'formatDate'));
    } // End Method
}

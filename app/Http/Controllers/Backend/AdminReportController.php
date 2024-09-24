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

class AdminReportController extends Controller
{
    public function AminAllReports()
    {
        return view('admin.backend.report.all_report');
    } // End Method
}

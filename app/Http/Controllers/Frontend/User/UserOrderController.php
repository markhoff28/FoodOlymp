<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class UserOrderController extends Controller
{
    public function UserOrderList()
    {
        $userId = Auth::user()->id;
        $allUserOrder = Order::where('user_id', $userId)->orderBy('id', 'desc')->get();
        return view('frontend.dashboard.order.order_list', compact('allUserOrder'));
    } //End Method

    public function UserOrderDetails($id)
    {
        $order = Order::with('user')->where('id', $id)->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id', $id)->orderBy('id', 'desc')->get();
        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }
        return view('frontend.dashboard.order.order_details', compact('order', 'orderItem', 'totalPrice'));
    }
    //End Method
}
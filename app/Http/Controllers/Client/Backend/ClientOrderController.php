<?php

namespace App\Http\Controllers\Client\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class ClientOrderController extends Controller
{
    public function AllClientOrders()
    {
        $clientId = Auth::guard('client')->id();
        $orderItemGroupData = OrderItem::with(['product', 'order'])->where('client_id', $clientId)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.order.all_orders', compact('orderItemGroupData'));
    } //End Method

    public function ClientOrderDetails($id)
    {
        $cid = Auth::guard('client')->id();
        $order = Order::with('user')->where('id', $id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $id)->where('client_id', $cid)->orderBy('id', 'desc')->get();
        $totalPrice = 0;
        foreach ($orderItem as $item) {
            $totalPrice += $item->price * $item->qty;
        }
        return view('client.backend.order.client_order_details', compact('order', 'orderItem', 'totalPrice'));
    } //End Method 
}

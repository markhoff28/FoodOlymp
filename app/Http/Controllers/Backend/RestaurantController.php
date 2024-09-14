<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class RestaurantController extends Controller
{
    public function PendingRestaurant()
    {
        $client = Client::where('status', 0)->get();
        return view('admin.backend.restaurant.pending_restaurant', compact('client'));
    } // End Method

    public function ClientChangeStatus(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->status = $request->status;
        $client->save();
        return response()->json(['success' => 'Status Change Successfully']);
    } // End Method 

    public function ApproveRestaurant()
    {
        $client = Client::where('status', 1)->get();
        return view('admin.backend.restaurant.approve_restaurant', compact('client'));
    } // End Method
}

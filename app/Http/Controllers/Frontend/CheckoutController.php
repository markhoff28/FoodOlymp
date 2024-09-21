<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function ShopCheckout(){
        if (Auth::check()) {
            $cart = session()->get('cart',[]);
            $totalAmount = 0;
            foreach ($cart as $car) {
                $totalAmount += $car['price'];
            }
            if ($totalAmount > 0) {
               return view('frontend.checkout.view_checkout', compact('cart'));
            } else {
                $notification = array(
                    'message' => 'Shopping at list one item',
                    'alert-type' => 'error'
                ); 
                return redirect()->to('/')->with($notification);
            } 
            
        }else{
            $notification = array(
                'message' => 'Please Login First',
                'alert-type' => 'success'
            );
    
            return redirect()->route('login')->with($notification); 
        } 
    }
    //End Method
}

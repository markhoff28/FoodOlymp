<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminChangePasswordController extends Controller
{
    public function AdminChangePassword()
    {
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    } // End Method

    public function AdminPasswordUpdate(Request $request){
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password,$admin->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        /// Update the new password 
        Admin::whereId($admin->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

                $notification = array(
                'message' => 'Password Change Successfully',
                'alert-type' => 'success'
            );
            return back()->with($notification);
     } // End Method
}

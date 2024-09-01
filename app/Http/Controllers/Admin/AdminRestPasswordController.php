<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\Websitemail;
use App\Models\Admin;

class AdminRestPasswordController extends Controller
{
    public function AdminForgetPassword()
    {
        return view('admin.forget_password');
    } // End Method

    public function AdminPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $adminData = Admin::where('email', $request->email)->first();
        if (!$adminData) {
            return redirect()->back()->with('error', 'Email Not Found');
        }
        $token = hash('sha256', time());
        $adminData->token = $token;
        $adminData->update();

        $resetLink = url('admin/reset-password/' . $token . '/' . $request->email);
        $subject = "Reset Password";
        $message = "Please Clink on below link to reset password<br>";
        $message .= "<a href='" . $resetLink . " '> Click Here </a>";

        \Mail::to($request->email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success', 'Reset Password Link Send On Your Email');
    } // End Method

    public function AdminResetPassword($token, $email)
    {
        $admin_data = Admin::where('email', $email)->where('token', $token)->first();

        if (!$admin_data) {
            return redirect()->route('admin.login')->with('error', 'Invalid Token or Email');
        }
        return view('admin.reset_password', compact('token', 'email'));
    } // End Method 

    public function AdminResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin_data = Admin::where('email', $request->email)->where('token', $request->token)->first();
        $admin_data->password = Hash::make($request->password);
        $admin_data->token = "";
        $admin_data->update();

        return redirect()->route('admin.login')->with('success', 'Password Reset Successfully');
    } // End Method
}

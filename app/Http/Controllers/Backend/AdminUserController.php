<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class AdminUserController extends Controller
{
    public function AllAdmin()
    {
        $alladmin = Admin::latest()->get();
        return view('admin.backend.pages.admin.all_admin', compact('alladmin'));
    } //End Method

    public function AddAdmin()
    {
        $roles = Role::all();
        return view('admin.backend.pages.admin.add_admin', compact('roles'));
    } //End Method

    public function StoreAdmin(Request $request)
    {
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = '1';
        $user->save();
        if ($request->roles) {
            $role = Role::where('id', $request->roles)->where('guard_name', 'admin')->first();
            if ($role) {
                $user->assignRole($role->name);
            }
        }
        $notification = array(
            'message' => 'New Admin Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    } //End Method

    public function EditAdmin($id){
        $admin = Admin::find($id);
        $roles = Role::all();
        return view('admin.backend.pages.admin.edit_admin',compact('roles','admin'));
    }
     //End Method
     public function UpdateAdmin(Request $request , $id){
        $user = Admin::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address; 
        $user->role = 'admin';
        $user->status = '1';
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
           $role = Role::where('id',$request->roles)->where('guard_name','admin')->first();
           if ($role) {
            $user->assignRole($role->name);
           }
        }
        $notification = array(
            'message' => 'New Admin Updated Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.admin')->with($notification); 
    }
     //End Method
}

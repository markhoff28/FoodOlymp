<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function AllRoles()
    {
        $roles = Role::all();
        return view('admin.backend.pages.roles.all_roles', compact('roles'));
    } // End Method

    public function AddRoles()
    {
        return view('admin.backend.pages.roles.add_roles');
    } // End Method

    public function StoreRoles(Request $request)
    {
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    } // End Method

    public function EditRoles($id)
    {
        $roles = Role::find($id);
        return view('admin.backend.pages.roles.edit_roles', compact('roles'));
    } // End Method 

    public function UpdateRoles(Request $request)
    {
        $role_id = $request->id;

        Role::find($role_id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    } // End Method 

    public function DeleteRoles($id)
    {
        Role::find($id)->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method
}

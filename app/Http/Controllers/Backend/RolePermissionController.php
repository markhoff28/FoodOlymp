<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use DB;

class RolePermissionController extends Controller
{
    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('admin.backend.pages.rolesetup.all_roles_permission', compact('roles'));
    } // End Method

    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();

        return view('admin.backend.pages.rolesetup.add_roles_permission', compact('roles', 'permission_groups', 'permissions'));
    } // End Method

    public function RolePermissionStore(Request $request)
    {
        $data = array();
        $permissions = $request->permission;
        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;
            DB::table('role_has_permissions')->insert($data);
        } //end foreach
        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with($notification);
    } //End Method

    public function AdminEditRoles($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = Admin::getpermissionGroups();

        return view('admin.backend.pages.rolesetup.edit_roles_permission', compact('role', 'permission_groups', 'permissions'));
    } // End Method

    public function AdminUpdateRoles(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = $request->permission;
        if (!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->$syncPermissions([]);
        }
        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with($notification);
    }
    //End Method

    public function AdminDeleteRoles($id)
    {
        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method
}

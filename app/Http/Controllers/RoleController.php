<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    //
     public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name', 'description'));
        return response()->json(['message' => 'Role created successfully!', 'role' => $role,"success"=> true]);
    }

    public function assignPermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($request->permission_id);
        $role->permissions()->attach($permission);

        return response()->json(['message' => 'Permission assigned successfully!']);
    }
}

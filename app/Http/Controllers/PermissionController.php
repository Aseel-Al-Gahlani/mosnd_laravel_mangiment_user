<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $permission = Permission::create($request->only('name', 'description'));
        return response()->json(['message' => 'Permission created successfully!', 'permission' => $permission,"success"=> true]);
    }
}

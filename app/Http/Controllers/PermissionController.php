<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
// use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    // for crud operations

    //load page
    public function index()
    {
        $permissions = Permission::get();
        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }

    //input
    public function create()
    {
        return view('role-permission.permission.create');
    }

    //add store function for storing to database
    public function store(Request $request) {

        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name' //unique in permissions table
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission created successfully');
    }

    // edit
    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }

    // update
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission updated successfully');
    }

    // delete
    public function destroy($permissionId)
    {
       $permission = Permission::find($permissionId);
       $permission->delete();
       return redirect('permissions')->with('status', 'Permission deleted successfully');
    }

}

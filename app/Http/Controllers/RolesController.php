<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Permission_Role;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public function index()
    {
        $role = Role::all();
        return view('role.show', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect(route('role.index'));
    }

    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::where('id', $id)->first();
        $users = User::where('active', 1)->get();
        return view('role.edit', compact('role', 'permissions', 'users'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect(route('role.index'));

    }

    public function addOrEditRoleUser(Request $request)
    {
        // Assuming you have the user_id and role_id from the $request
        $user_id = $request->input('user_id'); // Access user_id from $request
        $role_id = $request->input('role_id'); // Access role_id from $request

        // Define the data you want to update or create
        $data = [
            'role_id' => $role_id, // Assign role_id from $request
        ];
        // Use updateOrCreate
        RoleUser::updateOrCreate(['user_id' => $user_id], $data);
        return redirect()->back();
    }

    public function deleteRoleUser($id)
    {
        RoleUser::where('id', $id)->delete();
        return redirect()->back();
    }

    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        return redirect()->back();
    }
}

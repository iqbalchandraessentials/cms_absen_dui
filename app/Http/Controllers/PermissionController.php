<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index()
    {
        $permission = Permission::all();
        return view('permission.show', compact('permission'));
    }

    public function create()
    {
        $permissions = Permission::distinct()->pluck('for');


        return view('permission.create', compact('permissions'));
    }



    public function store(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->for = $request->for;
        $permission->save();
        return redirect(route('permission.index'));
    }


    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permission.edit', compact('permission'));
    }


    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->for = $request->for;
        $permission->save();
        return redirect(route('permission.index'));
    }


    public function destroy($id)
    {
        Permission::where('id', $id)->delete();
        return redirect()->back();
    }
}
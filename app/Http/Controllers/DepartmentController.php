<?php

namespace App\Http\Controllers;

use App\Imports\departmentImport;
use App\Models\Department;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class departmentController extends Controller
{
    public function index()
    {
        $data = Department::get();
        return view('department.index', ['data' => $data]);
    }

    public function show($id)
    {
        $data = Department::findOrFail($id);
        return view('department.show', ['data' => $data, ]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        Department::create($request);
        return redirect(route('department.index'));
    }

    public function update(Request $request, $id)
    {
        $location = Department::findOrFail($id);
        $location->update($request->all());
        return redirect(route('department.index'));
    }
}

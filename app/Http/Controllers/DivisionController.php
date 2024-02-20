<?php

namespace App\Http\Controllers;

use App\Imports\DivisionImport;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Division::get();
        return view('division.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        Division::create($request);
        return redirect(route('division.index'));
    }

    public function show($id)
    {
        $data = Division::findOrFail($id);
        return view('division.show', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $location = Division::findOrFail($id);
        $location->update($request->all());
        return redirect(route('division.index'));
    }
}

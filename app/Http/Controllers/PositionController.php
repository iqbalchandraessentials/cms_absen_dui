<?php

namespace App\Http\Controllers;

use App\Imports\PositionImport;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Position::get();
        return view('position.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        $posisi = Position::create($request);
        return redirect(route('position.index'));
    }

    public function show($id)
    {
        $data = Position::findOrFail($id);
        return view('position.show', ['data' => $data, ]);
    }

    public function update(Request $request, $id)
    {
        $location = Position::findOrFail($id);
        $location->update($request->all());
        return redirect(route('position.index'));
    }

}

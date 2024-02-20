<?php

namespace Modules\PinjamMobil\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\PinjamMobil\Entities\Vehicleslocations;


class VehicleslocationsController extends Controller
{
    public function index()
    {
        $data = Vehicleslocations::with('vehicle')->get();
        return view('pinjammobil::location.index', ['data'=>$data]);
    }

    public function store(Request $request)
    {
        // Validate the request

        Vehicleslocations::create($request->all());

        return redirect()->route('location-vehicles.index')
            ->with('success', 'Location created successfully');
    }

    public function show($id)
    {
        $data = Vehicleslocations::with('vehicle')->findOrFail($id);
        // dd($data);
        return view('pinjammobil::location.show', compact('data'));
    }

    public function edit($id)
    {
        $location = Vehicleslocations::findOrFail($id);
        return view('pinjammobil::locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request

        $location = Vehicleslocations::findOrFail($id);
        $location->update($request->all());

        return redirect()->route('location-vehicles.index')
            ->with('success', 'Location updated successfully');
    }

    public function destroy($id)
    {
        $location = Vehicleslocations::findOrFail($id);
        $location->delete();

        return redirect()->route('location-vehicles.index')
            ->with('success', 'Location deleted successfully');
    }
}

<?php

namespace Modules\PinjamMobil\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\PinjamMobil\Entities\Vehiclespic;


class VehiclespicController extends Controller
{
    public function index()
    {
        $data = Vehiclespic::all();
        $user = User::where('active', 1)->get();
        return view('pinjammobil::vehiclespic.index', ['data'=>$data, 'user'=>$user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add validation rules based on your model fields
        ]);

        Vehiclespic::create($request->all());

        return redirect()->route('pic-vehicles.index')
            ->with('success', 'Vehiclespic created successfully.');
    }

    public function show($id)
    {
        $data = Vehiclespic::with('vehicle')->findOrFail($id);
        // $user = User::where('active', 1)->get();
        return view('pinjammobil::vehiclespic.show', compact('data'));
    }

    public function edit(Vehiclespic $vehiclespic)
    {
        return view('pinjammobil::vehiclespic.edit', compact('vehiclespic'));
    }

    public function update(Request $request, $id)
    {

        $Vehiclespic = Vehiclespic::findOrFail($id);
        $Vehiclespic->update($request->all());

        return redirect()->route('pic-vehicles.index')
            ->with('success', 'Vehiclespic updated successfully');
    }

    public function destroy(Vehiclespic $vehiclespic)
    {
        $vehiclespic->delete();

        return redirect()->route('pic-vehicles.index')
            ->with('success', 'Vehiclespic deleted successfully');
    }
}

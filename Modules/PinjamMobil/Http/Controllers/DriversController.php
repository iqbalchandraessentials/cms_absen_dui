<?php

namespace Modules\PinjamMobil\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\PinjamMobil\Entities\Driver_Vehicle;


class DriversController extends Controller
{
    public function index()
    {
        $data = Driver_Vehicle::all();
        return view('pinjammobil::drivers.show', ['data' => $data]);
    }
    public function store(Request $request)
    {
        $driver = new Driver_Vehicle;
        $driver->name = $request->name;
        $driver->status = $request->status;
        $driver->save();
        return redirect()->route('drivers.index');
    }

    public function edit(Request $request, $id)
    {
        $data = Driver_Vehicle::find($id);
        return view('pinjammobil::drivers.edit', ['data' => $data]);
    }



    public function update(Request $request, $id)
    {

        $driver = Driver_Vehicle::find($id);
        $driver->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('drivers.index')
            ->with('success', 'driver updated successfully');
    }


}

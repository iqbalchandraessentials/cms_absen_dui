<?php

namespace Modules\PinjamMobil\Http\Controllers;

use App\Helpers\ImageIntervention;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PinjamMobil\Entities\Vehicles;
use Modules\PinjamMobil\Entities\BorrowVehicles;
use Modules\PinjamMobil\Transformers\VehicleResource;
use App\Helpers\ResponseFormatter;
use Modules\PinjamMobil\Entities\Driver_Vehicle;
use Modules\PinjamMobil\Entities\Vehicleslocations;
use Modules\PinjamMobil\Entities\Vehiclespic;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $vehicles = Vehicles::with('vehicle_locations', 'vehicle_pic')->where('active', 0)->get();
        return new VehicleResource($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = Vehicles::with('vehicle_locations', 'vehicle_pic')->get();
        $location = Vehicleslocations::get();
        $pic = Vehiclespic::get();
        return view('pinjammobil::vehicle.index', ['data' => $data, 'pic' => $pic, 'location' => $location]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'image.*' => 'image|mimes:jpeg,jpg,png,bmp',
                'no_polisi' => 'required|unique:vehicles,no_polisi',
                'nomor_rangka' => 'required|unique:vehicles,nomor_rangka',
                'nomor_mesin' => 'required|unique:vehicles,nomor_mesin',
            ]);

            $data_photo = ImageIntervention::compress($request->image, 'vehicle');

            $vehicle = new Vehicles;
            $vehicle->lokasi_id = $request->lokasi_id;
            $vehicle->pic_id = $request->pic_id;
            $vehicle->merek = $request->merek;
            $vehicle->type = $request->type;
            $vehicle->no_polisi = $request->no_polisi;
            $vehicle->nomor_rangka = $request->nomor_rangka;
            $vehicle->nomor_mesin = $request->nomor_mesin;
            $vehicle->pajak_berakhir = Carbon::parse($request->pajak_berakhir)->format('Y-m-d');
            $vehicle->stnk_berakhir = Carbon::parse($request->stnk_berakhir)->format('Y-m-d');
            $vehicle->last_km = $request->last_km;
            $vehicle->image = $data_photo;

            if ($vehicle->save()) {
                return redirect()->route('pinjammobil.create')->with('success', 'Vehicle created successfully.');
            } else {
                return redirect()->route('pinjammobil.create')->with('error', 'Failed to save the vehicle.');
            }
        } catch (ValidationException $e) {
            return redirect()->route('pinjammobil.create')->withErrors($e->errors());
        }
    }

    public function storeDriver(Request $request)
    {
        // Validate the request
        Driver_Vehicle::create($request->all());
        return redirect()->back()
            ->with('success', 'Driver created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        $vehicles = Vehicles::find($id);
        $borrow = BorrowVehicles::where('vehicles_id', $id)->get();
        $currentDate = Carbon::now();
        $endDate = $currentDate->copy()->addMonths(5);
        $listBorrow = BorrowVehicles::whereIn('status', [2, 4])->where('vehicles_id', $id)
            // ->where('start_date', '>=', $currentDate)
            // ->where('start_date', '<=', $endDate)
            ->get();
        // dd($listBorrow);

        $all_borrower = array();
        if (isset($listBorrow)) {
            foreach ($listBorrow as $y) {
                $borrower = [
                    'borrower' => $y->users->name,
                    'start_date' => $y->start_date,
                    'end_date' => $y->end_date,
                    'from' => $y->from,
                    'to' => $y->to,
                    'drivers' => $y->drivers->name ?? '-',
                ];

                array_push($all_borrower, $borrower);
            }
        }


        if ($vehicles) {
            $data = [
                'vehicle_lokasi' => array(
                    'lokasi_id' => $vehicles->lokasi_id,
                    'lokasi' => $vehicles->vehicle_locations->name,
                ),
                'vehicle_pic' => array(
                    'pic_id' => $vehicles->pic_id,
                    'pic' => $vehicles->vehicle_pic->users->name ?? '-',
                ),
                'list_borrow' => $all_borrower ?? '-',
                'merek' => $vehicles->merek,
                'type' => $vehicles->type,
                'nopol' => $vehicles->no_polisi,
                'active' => $vehicles->active,
                'nomor_rangka' => $vehicles->nomor_rangka,
                'nomor_mesin' => $vehicles->nomor_mesin,
                'pajak_berakhir' => $vehicles->pajak_berakhir,
                'stnk_berakhir' => $vehicles->stnk_berakhir,
                'last_km' => $vehicles->last_km,
                'id' => $id,
                'image' => asset('uploads/vehicle/' . $vehicles->image)
            ];
            $currentUrl = $request->url();
            if (str_contains($currentUrl, 'ga/pinjammobil')) {
                $location = Vehicleslocations::get();
                $pic = Vehiclespic::get();
                return view('pinjammobil::vehicle.show', ['data' => $data, 'pic' => $pic, 'location' => $location, 'borrow' => $borrow]);
            } else {
                return ResponseFormatter::success(
                    $data,
                    'success'
                );
            }
        } else {
            return ResponseFormatter::status('', 'Vehicle not found', 'Error');
        }
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'image.*' => 'image|mimes:jpeg,jpg,png,bmp',
                'no_polisi' => 'required|unique:vehicles,no_polisi,' . $id,
                'nomor_rangka' => 'required|unique:vehicles,nomor_rangka,' . $id,
                'nomor_mesin' => 'required|unique:vehicles,nomor_mesin,' . $id,
            ]);

            $vehicle = Vehicles::find($id);

            if (!$vehicle) {
                return redirect()->route('pinjammobil.show', $id)->with('error', 'Vehicle not found.');
            }

            $vehicle->lokasi_id = $request->lokasi_id;
            $vehicle->active = $request->active;
            $vehicle->pic_id = $request->pic_id;
            $vehicle->merek = $request->merek;
            $vehicle->type = $request->type;
            $vehicle->no_polisi = $request->no_polisi;
            $vehicle->nomor_rangka = $request->nomor_rangka;
            $vehicle->nomor_mesin = $request->nomor_mesin;
            $vehicle->pajak_berakhir = Carbon::parse($request->pajak_berakhir)->format('Y-m-d');
            $vehicle->stnk_berakhir = Carbon::parse($request->stnk_berakhir)->format('Y-m-d');
            $vehicle->last_km = $request->last_km;
            if (isset($request->image)) {
                $data_photo = ImageIntervention::compress($request->image, 'vehicle');
                $vehicle->image = $data_photo;
            }

            if ($vehicle->save()) {
                return redirect()->route('pinjammobil.show', $id)->with('success', 'Vehicle updated successfully.');
            } else {
                return redirect()->route('pinjammobil.show', $id)->with('error', 'Failed to update the vehicle.');
            }
        } catch (ValidationException $e) {
            return redirect()->route('pinjammobil.show', $id)->withErrors($e->errors());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Vehicles::where('id', $id)->delete();
        return ResponseFormatter::success(
            'Vehicle is destroyed',
            'Success'
        );
    }

    public function get_lokasi()
    {
        $lokasi_vehicle = Vehicleslocations::all();
        return ResponseFormatter::success(
            $lokasi_vehicle,
            'success'
        );
    }

    public function get_pic()
    {
        $pic_vehicle = Vehiclespic::all();
        return ResponseFormatter::success(
            $pic_vehicle,
            'success'
        );
    }

    public function get_driver()
    {
        $driver_vehicle = Driver_Vehicle::where('status', '1')->get();
        return ResponseFormatter::success(
            $driver_vehicle,
            'success'
        );
    }
}

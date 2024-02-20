<?php

namespace Modules\PinjamMobil\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\PinjamMobil\Entities\BorrowVehicles;
use Modules\PinjamMobil\Entities\Vehicles;

class VehicleResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($vehicle) {
            $id = $vehicle->id;
            $currentdate = Carbon::now();
            $reserve = Vehicles::find($id);
            $currentDate = Carbon::now();
            $endDate = $currentDate->copy()->addMonths(5);
            $listBorrow = BorrowVehicles::whereIn('status', [2, 4])->where('vehicles_id', $vehicle->id)
                // ->where('start_date', '>=', $currentDate)
                // ->where('start_date', '<=', $endDate)
                ->get();

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
            // $km = $reserve->km()->latest()->first();
            $km = $reserve->last_km;
            $reserve_schedule = $reserve->borrow($currentdate)->first();
            $status = 'Tersedia';
            if (isset($reserve_schedule)) {
                $is_ga = BorrowVehicles::find($reserve_schedule->id);
                if (isset($is_ga->ga_approve)) {
                    $ga_user = $is_ga->ga_approve->ga_approval_id;
                    $status = (in_array($is_ga->status, [2, 4])) ? 'Tidak Tersedia' : 'Tersedia';
                }
            }
            return [
                'id' => $vehicle->id,
                'image' => $vehicle->image,
                'location' => $vehicle->vehicle_locations->name,
                'pic' => $vehicle->vehicle_pic->users->name ?? '-',
                'merek' => $vehicle->merek,
                'type' => $vehicle->type,
                'nopol' => $vehicle->no_polisi,
                'nomor_rangka' => $vehicle->nomor_rangka,
                'nomor_mesin' => $vehicle->nomor_mesin,
                'pajak_berakhir' => $vehicle->pajak_berakhir,
                'stnk_berakhir' => $vehicle->stnk_berakhir,
                'km' => $km ?? '-',
                'listBorrow' => $all_borrower ?? '-',
                'status' => array(
                    'ga_user' => $ga_user ?? '-',
                    'status' => $status,
                ),
            ];
        });
    }
}

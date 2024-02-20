<?php

namespace Modules\PinjamMobil\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\ImageIntervention;
use App\Helpers\ResponseFormatter;
use Modules\PinjamMobil\Entities\GAReturnApproval;
use Modules\PinjamMobil\Entities\KMHistory;
use Modules\PinjamMobil\Entities\Vehicles;
use App\Models\User;
use Modules\PinjamMobil\Entities\Vehicleslocations;
use Modules\PinjamMobil\Entities\VehiclesReturn;
use Modules\PinjamMobil\Entities\VehiclesReturnAttachment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Modules\PinjamMobil\Entities\BorrowVehicles;

class VehiclesReturnController extends Controller
{

    public function store(Request $request, $id, User $user)
    {

        $request->validate([
            'upload_file.*' => 'required|mimes:jpeg,jpg,png',
        ]);

        $now = Carbon::now();
        $next_km = $request->next_km;
        $get_last_position = $request->last_position;

        $attachments = [];
        foreach ($request->upload_file as $file) {
            $attachments[] = [
                'borrow_id' => $id,
                'upload_file' => ImageIntervention::compress($file, 'return_vehicle'),
            ];
        }
        VehiclesReturnAttachment::insert($attachments);

        $vehicle_return = new VehiclesReturn;
        $vehicle_return->borrow_id = $id;
        $vehicle_return->body = $request->body ?? "0";
        $vehicle_return->lampu = $request->lampu ?? "0";
        $vehicle_return->ban = $request->ban ?? "0";
        $vehicle_return->ac = $request->ac ?? "0";
        $vehicle_return->mesin = $request->mesin ?? "0";
        $vehicle_return->last_position = $request->last_position;
        $vehicle_return->description = $request->description;
        $vehicle_return->request_date = $now;

        $data = BorrowVehicles::find($id);
        $data->update([
            'status' => 4,
        ]);

        if ($vehicle_return->save()) {
            $get_history_km = KMHistory::where('vehicles_id', $vehicle_return->borrow->vehicles_id)->latest()->first();
            $get_last_km = $data->vehicles->last_km;

            if ($get_history_km) {
                $first_km = $get_history_km->next_km;
            } else {
                $first_km = $get_last_km;
            }

            KMHistory::updateOrInsert(
                ['id' => $vehicle_return->id],
                [
                    'vehicles_id' => $vehicle_return->borrow->vehicles_id,
                    'borrowing_id' => $id,
                    'return_id' => $vehicle_return->id,
                    'first_km' => $first_km,
                    'next_km' => $next_km,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]
            );

            $vehicle = Vehicles::where('id', $data->vehicles_id)->first();
            if (isset($get_last_position)) {
                $last_position = $get_last_position;
            } else {
                $last_position = $vehicle->lokasi_id;
            }

            $vehicle->update([
                'lokasi_id' => $last_position,
                'last_km' => $next_km
            ]);

            $pic = $data->vehicles->vehicle_pic->user_id;
            $pic_approval = $user->find($pic);

            $user->sendNotification($pic_approval->nik, "Pinjam Mobil", "Return vehicle borrow request Need your approval 🙏🏼", "approve-head-borrow");

            return ResponseFormatter::success(
                $vehicle_return,
                'Success'
            );
        } else {
            return ResponseFormatter::status('', 'Something went wrong', 'Error');
        }
    }

    public function ga_approve_return(Request $request, $id, User $user)
    {
        $id_user = Auth::id();
        $get_last_position = $request->last_position;
        $next_km = $request->next_km;
        $approved_date = date('Y-m-d H:i', strtotime($request->date_time));
        $data = VehiclesReturn::where('borrow_id', $id)->first();
        $y = BorrowVehicles::find($id);
        $y->update([
            'status' => 5,
        ]);
        $km_history = $y->km_history;
        $id_borrow = $data->borrow->id;
        $ga_return = new GAReturnApproval;
        $ga_return->borrow_id = $id_borrow;
        $ga_return->return_id = $data->id;
        $ga_return->ga_approval_id = $id_user;
        $ga_return->description = $request->description;
        $ga_return->last_position = $request->last_position;
        $ga_return->approved_date = $approved_date;
        $ga_return->status = 1;
        $ga_return->save();

        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }

        $data->update([
            'body' => $request->body == "1" ? "1" : "0",
            'lampu' => $request->lampu == "1" ? "1" : "0",
            'ban' => $request->ban == "1" ? "1" : "0",
            'ac' => $request->ac == "1" ? "1" : "0",
            'mesin' => $request->mesin == "1" ? "1" : "0",
            'description' => $request->description,
            'approved_date' => date('Y-m-d H:i', strtotime($request->date_time)),
        ]);

        $km_history->update([
            'return_id' => $data->id,
            'next_km' => $next_km,
        ]);

        $vehicle = Vehicles::where('id', $y->vehicles_id)->first();
        if (isset($get_last_position)) {
            $last_position = $get_last_position;
        } else {
            $last_position = $vehicle->lokasi_id;
        }

        $vehicle->update([
            'lokasi_id' => $last_position,
            'last_km' => $next_km
        ]);

        $user_request = $user->find($y->user_id);
        $user->sendNotification($user_request->nik, "Pinjam Mobil", "Your retutn Vehicle borrow has been accepted", "approve-head-borrow");

        return ResponseFormatter::success(
            $data,
            'success'
        );
    }
}




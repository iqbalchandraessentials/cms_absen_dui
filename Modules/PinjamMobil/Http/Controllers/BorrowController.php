<?php

namespace Modules\PinjamMobil\Http\Controllers;

use App\Exceptions\BorrowNotBelongsToUser;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PinjamMobil\Entities\BorrowVehicles;
use Modules\PinjamMobil\Entities\Driver_Vehicle;
use Modules\PinjamMobil\Http\Requests\BorrowRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\PinjamMobil\Entities\GABorrowVehicles;
use Modules\PinjamMobil\Entities\KMHistory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Exports\BorrowVehiclesExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class BorrowController extends Controller
{

    use ValidatesRequests;
    public function Notification($approve)
    {
        switch ($approve) {
            case '1':
                $notif = "approved ✅";
                break;
            case '2':
                $notif = "rejected ❌";
                break;
            case '3':
                $notif = "canceled 🚫";
                break;
            default:
                $notif = "oops!";
        }
        return $notif;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $all_mobil = array();
        $data = BorrowVehicles::with('km_history')->where('user_id', Auth::id())->get();
        foreach ($data as $set_app) {
            $is_ga = BorrowVehicles::find($set_app->id)->ga_approve;
            if (isset($is_ga)) {
                $approve = '1';
                $set_app->approve = $approve;
            } else {
                $set_app->approve = '0';
            }
        }
        if ($data) {
            foreach ($data as $y) {
                $user = User::find($y->owners);
                $history_next_km = KMHistory::where('vehicles_id', $y->vehicles_id)->latest()->first(); //get las next_km

                // if (isset($y->ga_approve->status)) {
                //     $status = ($y->ga_approve->status == 1) ? 'Tidak Tersedia' : 'Tersedia';
                // } else {
                //     $status = '0';
                // }


                $data_all = [
                    'id' => $y->id,
                    'vehicle' => array(
                        'vehicle_id' => $y->vehicles_id,
                        'vehicle_type' => $y->vehicles->type,
                        'vehicle_nopol' => $y->vehicles->no_polisi,
                    ),
                    'KM' => array(
                        'last_km' => $history_next_km->next_km ?? '-',
                    ),
                    'driver' => array(
                        'name' => $y->drivers->name ?? '-',
                    ),
                    'user' => array(
                        'user_id' => $y->users->id,
                        'name' => $y->users->name,
                        'photo_path' => $y->users->photo_path,
                        'departement' => $y->users->department->name,
                        'division' => $y->users->division->name,
                        'jabatan' => $y->users->position->name,
                    ),
                    'start_date' => $y->start_date,
                    'end_date' => $y->end_date,
                    'from' => $y->from,
                    'to' => $y->to,
                    'reason' => $y->reason,
                    'cost_center' => $y->cost_center,
                    'request_date' => $y->request_date ?? '-',
                    'approve' => $y->approve,
                    'approval' => array(
                        'id' => $y->owners,
                        // 'status' => ($y->approved == 0) ? '-' : "$y->approved",
                        'status' => "$y->approved" ?? '0',
                        'head_name' => $user->name,
                        'approved_date' => $y->approved_date ?? '-',
                    ),
                    'approval_GA' => array(
                        'id' => $y->ga_approve->ga_approval_id ?? '-',
                        'status' => $y->ga_approve->status ?? '0',
                        'GA_approved_date' => $y->ga_approve->approved_date ?? '-',
                    ),
                    'label' => 'mobil',
                    'status_mobil' => $y->status,
                    'updated_at' => $y->updated_at,
                    'is_ga' => false,
                ];

                switch ($y->status) {
                    case 0:
                        $data_all['keterangan'] = 'Menunggu approval atasan';
                        break;
                    case 1:
                        $data_all['keterangan'] = 'Disetujui atasan, menunggu approval GA';
                        break;
                    case 2:
                        $data_all['keterangan'] = 'Disetujui GA';
                        break;
                    case 3:
                        $data_all['keterangan'] = 'Dibatalkan';
                        break;
                    case 4:
                        $data_all['keterangan'] = 'Menunggu persetujuan pengembalian';
                        ;
                        break;
                    case 5:
                        $data_all['keterangan'] = 'Selesai';
                        break;
                    default:
                        $data_all['keterangan'] = 'Status tidak dikenali';
                        break;
                }

                array_push($all_mobil, $data_all);
            }

            usort($all_mobil, function ($item1, $item2) {
                // First, sort by 'approve' in ascending order
                if ($item1['approve'] != $item2['approve']) {
                    return $item1['approve'] <=> $item2['approve'];
                }

                // If 'approve' is the same, then sort by 'updated_at' in descending order
                return strtotime($item2['updated_at']) <=> strtotime($item1['updated_at']);
            });

            return ResponseFormatter::success(
                $all_mobil,
                'success'
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = BorrowVehicles::with('km_history', 'ga_approve')->get();
        // dd($data);
        return view('pinjammobil::borrow.index', ['data' => $data]);
    }


    public function store(BorrowRequest $request, User $user)
    {
        $approval = Auth::user()->approval_line_id;
        $atasan = $user->find($approval);

        $now = Carbon::now();
        $user_id = Auth::id();
        $vehiclesId = $request->vehicles_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        try {
            $borrow = new BorrowVehicles;
            $borrow->vehicles_id = $vehiclesId;
            $borrow->user_id = $user_id;
            $borrow->start_date = $start_date;
            $borrow->end_date = $end_date;
            $borrow->from = $request->from;
            $borrow->to = $request->to;
            $borrow->reason = $request->reason;
            $borrow->driver_id = $request->driver_id;
            $borrow->cost_center = $request->cost_center;
            $borrow->owners = Auth::user()->approval_line_id;
            $borrow->request_date = $now;
            $borrow->save();

            $user->sendNotification($atasan->nik, Auth::user()->name, "Need your approval for vehicle borrow request at $request->start_date 🙏🏼", "approval");

            return ResponseFormatter::success(
                $borrow,
                'Success'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => (string) $error->getMessage()
            ], 'Something went wrong', 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('approval-ga')) {
            $this->BorrowUserCheck($id);
        }
        // $borrow = BorrowVehicles::find($id);
        $all_driver = Driver_Vehicle::where('status', '1')->get();
        $borrow = BorrowVehicles::with('km_history', 'ga_approve', 'return_vehicles')->find($id);
        if (isset($borrow->attachment)) {
            foreach ($borrow->attachment as $x) {
                $upload_file[] = $x->upload_file;
            }
        }
        if ($borrow) {
            $data = [
                'id' => $borrow->id,
                'vehicle' => array(
                    'vehicle_id' => $borrow->vehicles_id,
                    'merek' => $borrow->vehicles->merek,
                    'vehicle_type' => $borrow->vehicles->type,
                    'vehicle_nopol' => $borrow->vehicles->no_polisi,
                    'image' => asset('uploads/vehicle/' . $borrow->vehicles->image)
                ),
                'KM' => array(
                    'last_km' => $borrow->km_history->next_km ?? '-',
                ),
                'driver' => array(
                    'name' => $borrow->drivers->name ?? '-',
                    'id' => $borrow->drivers->id ?? '-',
                ),
                'user' => array(
                    'user_id' => $borrow->users->id,
                    'name' => $borrow->users->name,
                    'photo_path' => $borrow->users->photo_path,
                    'departement' => $borrow->users->department->name,
                    'division' => $borrow->users->department->name,
                    'jabatan' => $borrow->users->position->name,
                ),
                'condition' => array(
                    'return_vehicles_id' => $borrow->return_vehicles->id ?? '-',
                    'body' => $borrow->return_vehicles->body ?? '-',
                    'lampu' => $borrow->return_vehicles->lampu ?? '-',
                    'ban' => $borrow->return_vehicles->ban ?? '-',
                    'ac' => $borrow->return_vehicles->ac ?? '-',
                    'mesin' => $borrow->return_vehicles->mesin ?? '-',
                    'description' => $borrow->return_vehicles->description ?? '-',
                    'upload_file' => $upload_file ?? '-',
                ),

                'start_date' => $borrow->start_date,
                'end_date' => $borrow->end_date,
                'from' => $borrow->from,
                'to' => $borrow->to,
                'reason' => $borrow->reason,
                'request_date' => $borrow->request_date,
                'cost_center' => $borrow->cost_center,
                'approved' => ($borrow->approved == '1') ? 'Approved' : 'Not Approved',
                'status_mobil' => $borrow->status,
                'status_ga' => $borrow->ga_approve->status ?? '-',
            ];

            switch ($borrow->status) {
                case 0:
                    $data['keterangan'] = 'Menunggu approval atasan';
                    break;
                case 1:
                    $data['keterangan'] = 'Disetujui atasan, menunggu approval GA';
                    break;
                case 2:
                    $data['keterangan'] = 'Disetujui GA';
                    break;
                case 3:
                    $data['keterangan'] = 'Dibatalkan';
                    break;
                case 4:
                    $data['keterangan'] = 'Menunggu persetujuan pengembalian';
                    break;
                case 5:
                    $data['keterangan'] = 'Selesai';
                    break;
                default:
                    $data['keterangan'] = 'Status tidak dikenali';
                    break;
            }

            $currentUrl = $request->url();

            if (str_contains($currentUrl, 'ga/borrow-vehicles/')) {
                return view('pinjammobil::borrow.show', ['data' => $data, 'all_driver' => $all_driver]);
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pinjammobil::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id, User $user)
    {
        $borrow = BorrowVehicles::find($id);


        if ($request->status == '2') {
            $status_borrow = '6';
            $user_request = $user->find($borrow->user_id);
            $user->sendNotification($user_request->nik, "Pinjam Mobil", "your vehicle borrow request has been rejected by GA 🙏🏼", "approve-ga-borrow");
        } else {
            $status_borrow = $borrow->status;
        }
        $borrow->update([
            'driver_id' => $request->driver,
            'status' => $status_borrow,
        ]);

        $approval_ga = $borrow->ga_approve;
        if (isset($approval_ga)) {
            $approval_ga->update([
                'status' => $request->status,
            ]);
        }



        return redirect()->route('borrow-vehicles.show', $id);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function BorrowUserCheck($id)
    {
        $borrow = BorrowVehicles::find($id);
        if (Auth::id() !== $borrow->user_id) {
            throw new BorrowNotBelongsToUser;
        }
    }

    public function head_approve(Request $request, $id, User $user)
    {
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approved' => 'required',
            ]
        );
        $data = BorrowVehicles::find($id);
        $pic = $data->vehicles->vehicle_pic->user_id;
        $pic_approval = $user->find($pic);
        // dd($pic_approval->nik);
        $user_request = $user->find($data->user_id);
        $request_date = date('Y-m-d H:i', strtotime($data->request_date));

        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }

        $approvalStatus = $request->approved;

        switch ($approvalStatus) {
            case 1:
                $y = 1;
                break;
            case 2:
                $y = 3;
                break;
        }

        $data->update([
            'approved' => $approvalStatus,
            'status' => $y,
            'approved_date' => date('Y-m-d H:i', strtotime($request->date_time)),
        ]);

        $notif = $this->Notification($request->approved);
        $user->sendNotification($user_request->nik, "Pinjam Mobil", "Your Vehicle borrow has been $notif", "approve-head-borrow");

        if ($approvalStatus == 1) {
            $roleUser = RoleUser::where('user_id',$pic_approval->id)->first();
            $notif = RoleUser::where('role_id', 21)->get();
            if ($roleUser->role_id == 21){
                foreach ($notif as  $x) {
                    $user->sendNotification($x->user->nik, "Pinjam Mobil", "Need your approval for vehicle borrow request at $data->start_date 🙏🏼", "approve-head-borrow");
                }
            }
            $user->sendNotification($pic_approval->nik, "Pinjam Mobil", "Need your approval for vehicle borrow request at $data->start_date 🙏🏼", "approve-head-borrow");
        }

        return ResponseFormatter::success(
            $data,
            'success'
        );
    }

    public function ga_approve_req(Request $request, $id, User $user)
    {
        $id_ga = Auth::id();
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approved' => 'required',
            ]
        );
        $approved_date = date('Y-m-d H:i', strtotime($request->date_time));
        $approvalStatus = $request->approved;
        switch ($approvalStatus) {
            case 1:
                $y = 2;
                break;
            case 2:
                $y = 3;
                break;
        }
        $data = BorrowVehicles::find($id);
        $data->update([
            'status' => $y,
        ]);
        $user_request = $user->find($data->user_id);
        $request_date = date('Y-m-d H:i', strtotime($data->request_date));
        $ga_approve = new GABorrowVehicles;
        $ga_approve->borrow_id = $id;
        $ga_approve->ga_approval_id = $id_ga;
        $ga_approve->status = $request->approved;
        $ga_approve->reasons = $request->reasons;
        $ga_approve->approved_date = $approved_date;
        $ga_approve->save();
        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }
        $notif = $this->Notification($request->approved);
        $user->sendNotification($user_request->nik, "Pinjam Mobil", "Your Vehicle borrow has been $notif", "approve-ga-borrow");
        return ResponseFormatter::success(
            $data,
            'success'
        );
    }

    public function cancelVehicleApproval(Request $request)
    {
        $id = $request->id;

        $borrow = BorrowVehicles::find($id);

        if (Auth::id() !== $borrow->user_id) {
            return response()->json(['error' => 'Access denied']);
        }

        if (!$borrow) {
            return response()->json(['error' => 'Not found']);
        }

        $borrow->update([
            'approved' => 3,
            'status' => 3,
        ]);

        return ResponseFormatter::success();
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $startDate = date("Y-m-d", strtotime($request->start_date));
        $endDate = date("Y-m-d", strtotime($request->end_date));
        return Excel::download(new BorrowVehiclesExport($startDate, $endDate), 'borrow_vehicles.xlsx');
    }
}

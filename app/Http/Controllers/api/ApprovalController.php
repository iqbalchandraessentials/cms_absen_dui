<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\Attendances;
use App\Models\KuotaCuti;
use App\Models\LogCutiTahunan;
use App\Models\Overtime;
use App\Models\RequestAttendance;
use App\Models\RequestTimeoff;
use App\Models\User;
use App\Models\RequestOutOfRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\PinjamMobil\Entities\BorrowVehicles;
use Modules\PinjamMobil\Entities\VehiclesReturnAttachment;

class ApprovalController extends Controller
{

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

    public function AttendanceRequest(Request $request, $id, User $user)
    {
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approve' => 'required',
            ]
        );
        $data = RequestAttendance::find($id);
        $user_id = $data->user_id;
        $approval_notif = User::find($user_id);
        $selected_date = date('Y-m-d', strtotime($data->selected_date));
        //ini ngajuin clock in
        // $attendances = Attendances::whereDate('check_out', $date_conv_in)->orWhere('check_in', $date_conv_out)->where('user_id', $data->user_id)->first();
        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }
        // dd($attendances);
        $data->update([
            'approve' => $request->approve,
            'approve_date' => date('Y-m-d H:i', strtotime($request->date_time)),
        ]);

        if ($request->approve == 1) {
            $clockIn = $data->clock_in;
            $clockOut = $data->clock_out;
            $existingAttendance = isset($clockIn) && isset($clockOut)
                ? Attendances::where('user_id', $user_id)
                ->whereDate('check_in', $selected_date)
                ->get()
                ->last()
                : Attendances::where('user_id', $user_id)
                ->where(function ($query) use ($selected_date) {
                    $query->whereDate('check_in', $selected_date)
                        ->orWhereDate('check_out', $selected_date);
                })
                ->get()
                ->last();
            $shift_today = $user->getshifttoday($data->user_id, $data->selected_date);
            $data_today = $shift_today->original['data'];
            $shift_id = $data_today->Shift->id;

            if ($existingAttendance) {
                if (isset($clockIn)) {
                    $existingAttendance->check_in = $clockIn;
                    $existingAttendance->description_in = $data->description;
                    $existingAttendance->img_check_in = 'request_attendance';
                    $existingAttendance->live_absen_in = '0';
                }

                if (isset($clockOut)) {
                    $existingAttendance->check_out = $clockOut;
                    $existingAttendance->description_out = $data->description;
                    $existingAttendance->img_check_out = 'request_attendance';
                    $existingAttendance->live_absen_out = '0';
                }

                if (isset($clockIn) && isset($clockOut)) {
                    $existingAttendance->status = 'H';
                    $existingAttendance->user_id = $data->user_id;
                    $existingAttendance->shift_id = $shift_id;
                }

                $existingAttendance->save();
            } else {
                $newAttendance = new Attendances;
                $newAttendance->check_in = $clockIn;
                $newAttendance->check_out = $clockOut;
                $newAttendance->description_in = $data->description;
                $newAttendance->description_out = $data->description;
                $newAttendance->img_check_in = 'request_attendance';
                $newAttendance->img_check_out = 'request_attendance';
                $newAttendance->live_absen_in = '0';
                $newAttendance->live_absen_out = '0';
                $newAttendance->status = 'H';
                $newAttendance->user_id = $data->user_id;
                $newAttendance->shift_id = $shift_id;
                $newAttendance->save();
            }
        }
        $notif = $this->Notification($request->approve);
        $user->sendNotification($approval_notif->nik, "Attendances", "Your attendance request at $data->selected_date has been $notif", "request-attendance");
        return ResponseFormatter::success('', 'Data telah terkirim');
    }

    public function timeoffUpdate(Request $request, $id, User $user)
    {
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approve' => 'required',
            ]
        );

        $data = RequestTimeoff::find($id);
        $request_date = date('Y-m-d', strtotime($data->request_date));

        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }

        $user_request = $user->find($data->user_id);

        $data->update([
            'approve' => $request->approve,
            'approve_date' => date('Y-m-d H:i', strtotime($request->date_time)),
        ]);

        $dates = $user->getBetweenDates($data->start_date, $data->end_date);
        $holiday = $user->get_holiday($data->start_date, $data->end_date);
        foreach ($holiday as $h) {
            if (isset($h)) {
                if ($key = array_search($h->holiday_date, $dates)) {
                    unset($dates[$key]);
                }
            }
        }
        $dates = $user->getshiftrange($data->user_id, date('Y-m-d', strtotime($data->start_date)), date('Y-m-d', strtotime($data->end_date)), $dates);

        $now = Carbon::now();
        if ($request->approve == 1) {
            if ($data->timeoff_id == 1) {
                $m = new LogCutiTahunan;
                $m->user_id = $data->user_id;
                $m->total_pengajuan = count($dates);
                $m->cuti_exists = $user->kuota_cuti($data->user_id);
                $m->save();

                $cuti_kuota = $user_request->cuti_kuota;
                $c = KuotaCuti::find($cuti_kuota->id);
                if ($now->month <= 6) {
                    $kuota_sisa = $c->kuota_sisa - count($dates);
                    if ($kuota_sisa >= 0) {
                        $kuota_sisa = $kuota_sisa;
                    } else {
                        $kuota_sisa = 0;
                        $kuota_cuti = $c->kuota_cuti - abs($kuota_sisa);
                    }
                } else {
                    $kuota_sisa = $c->kuota_sisa;
                    $kuota_cuti = $c->kuota_cuti - count($dates);
                }
                $c->sisa_cuti = $kuota_sisa;
                $c->kuota_cuti = $kuota_cuti;
                $c->save();
            }

            foreach ($dates as $tanggal) {
                $shift_today = $user->getshifttoday($data->user_id, $tanggal, 'get_shift');
                $data_today = $shift_today->original['data'];
                if ($data_today->Shift->id == "-") {
                    $shift_id = '1';
                } else {
                    $shift_id = $data_today->Shift->id;
                }
                $m = new Attendances;
                $m->check_in = $tanggal;
                $m->check_out = $tanggal;
                $m->description_in = $data->description;
                $m->live_absen_in = '0';
                $m->live_absen_out = '0';
                $m->status = $data->timeoff->code;
                $m->user_id = $data->user_id;
                $m->shift_id = $shift_id;
                $m->timeoff_id = $id;
                $m->save();
            }
        }
        $notif = $this->Notification($request->approve);
        $user->sendNotification($user_request->nik, "Time Off", "Your time off request at $request_date has been $notif", "request-timeoff");
        return ResponseFormatter::success('', 'Data telah terkirim');
    }

    public function overtimeUpdate(Request $request, $id, User $user)
    {
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approve' => 'required',
            ]
        );
        $data = Overtime::find($id);
        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }
        $approval_notif = $user->find($data->user_id);
        $data->update([
            'approve' => $request->approve,
            'approve_date' => date('Y-m-d H:i', strtotime($request->date_time)),
        ]);
        if ($request->approve == 1) {
            $attendances = Attendances::whereDate('created_at', $data->selected_date)->where('user_id', $data->user_id)->first();
            if ($attendances) {
                $attendances->update([
                    'overtime_after' => $data->overtime_duration_after,
                    'overtime_before' => $data->overtime_duration_before,
                ]);
            } else {
                return ResponseFormatter::error('', 'tanggal tersebut belum melakukan absent');
            }
        }
        $notif = $this->Notification($request->approve);
        $user->sendNotification($approval_notif->nik, "Attendances", "Your overtime request at $data->selected_date has been $notif", "request-overtime");
        return ResponseFormatter::success('', 'Data telah terkirim');
    }

    public function approvalRadiusUpdate(Request $request, $id, User $user)
    {
        $this->validate(
            $request,
            [
                'date_time' => 'required',
                'approve' => 'required',
            ]
        );
        $data = RequestOutOfRange::find($id);
        $user_shift = new User();
        $date = date('Y-m-d', strtotime($data->request_date));
        $date_time = date('Y-m-d H:i', strtotime($data->request_date));
        $shift = $user_shift->getshifttoday($data->user_id, $date);
        $data_shift = $shift->original['data'];
        $shift_id = $data_shift->Shift->id;

        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }

        $approval_notif = $user->find($data->user_id);
        $data->update([
            'approval' => $request->approve,
            'approve_date' => $request->date_time,
        ]);
        if ($request->approve == '1') {
            $check = Attendances::where('user_id', $data->user_id)
                ->where(function ($query) use ($date) {
                    $query->whereDate('check_in', $date)
                        ->orWhereDate('check_out', $date);
                })->first();
            if (!$check) {
                $check = new Attendances;
                $check->user_id = $data->user_id;
                $check->shift_id = $shift_id;
            }
            $checkType = ($data->type == 'in') ? 'in' : 'out';
            $check->{"check_$checkType"} = $date_time;
            $check->{"longitude_$checkType"} = $data->longitude;
            $check->{"latitude_$checkType"} = $data->latitude;
            $check->{"description_$checkType"} = $data->description;
            $check->{"img_check_$checkType"} = $data->image;
            $check->{"live_absen_$checkType"} = '0';
            $check->save();
        }
        $notif = $this->Notification($request->approve);
        $user->sendNotification($approval_notif->nik, "Out Of Radius", "Your out of range attendance request at $data->created_at has been $notif", "request-outofrange");
        return ResponseFormatter::success('', 'Data telah terkirim');
    }

    public function timeoffList()
    {
        $data = RequestTimeoff::where('user_id', Auth::user()->id)->with(['timeoff', 'user.division', 'user', 'user.position', 'user.department', 'approveby', 'attachment', 'delegation'])->oldest()->get();
        return $data;
    }

    public function overtimeList()
    {
        $data = Overtime::where('user_id', Auth::user()->id)->with('user', 'user.division', 'user.position', 'user.department', 'attachment', 'approveby')->get();
        return $data;
    }

    public function attendanceList()
    {

        $data = RequestAttendance::where('user_id', Auth::user()->id)->with('user', 'user.division', 'user.position', 'user.department', 'approveby')->oldest()->get();

        foreach ($data as $value) {
            if ($value->clock_in && $value->clock_out) {
                $value->status = 'Clock in dan Clock out';
            } else {
                if ($value->clock_in) {
                    $value->status = 'Clock in';
                } else {
                    $value->status = 'Clock out';
                }
            }
        }
        return $data;
    }

    public function outofrangeList()
    {
        $data = RequestOutOfRange::where('user_id', Auth::user()->id)->with(['user', 'user.division', 'user.position', 'user.department', 'approveby', 'attendance'])->oldest()->get();

        $data = $data->map(function ($item, $key) {
            $item = collect($item)->toArray();
            if (array_key_exists('approval', $item)) {
                $item['approve'] = $item['approval'];
                unset($item['approval']);
            }
            return $item;
        });
        return $data;
    }

    public function pengajuan(Request $req)
    {
        $types = ['timeoff', 'overtime', 'attendance', 'outofrange'];

        $data = [];

        if (in_array($req->type, $types)) {
            $items = $this->{$req->type . 'List'}();
            foreach ($items as $item) {
                $item['label'] = $req->type;
                $data[] = $item;
            }
        } else {
            foreach ($types as $type) {
                $items = $this->{$type . 'List'}();
                foreach ($items as $item) {
                    $item['label'] = $type;
                    $data[] = $item;
                }
            }
        }
        usort($data, function ($item1, $item2) {
            return $item2['updated_at'] <=> $item1['updated_at'];
        });

        if (in_array($req->type, $types)) {
            return ResponseFormatter::success($data, 'Data pengajuan ' . $req->type . ' berhasil diambil');
        } else {
            return ResponseFormatter::success($data, 'Data pengajuan berhasil diambil');
        }
    }

    public function attendanceShow($id)
    {
        $data = RequestAttendance::with('user', 'attachment')->find($id);
        foreach ($data as $value) {
            if ($value->clock_in && $value->clock_out) {
                $value->status = 'Clock in dan Clock out';
            } else {
                if ($value->clock_in) {
                    $value->status = 'Clock in';
                } else {
                    $value->status = 'Clock out';
                }
            }
        }
        return $data;
    }

    public function timeoffShow($id)
    {
        $data = RequestTimeoff::with(['user', 'timeoff', 'attachment'])->find($id);
        return $data;
    }

    public function overtimeShow($id)
    {
        $data = Overtime::with('user', 'attachment')->find($id);
        return $data;
    }

    public function detailPengajuan(Request $req)
    {
        $data = $this->{$req->type . 'Show'}($req->id);
        if ($data) {
            return ResponseFormatter::success($data, 'Data ' . $req->type . ' berhasil diambil');
        } else {
            return ResponseFormatter::status('', 'Data not found berhasil diambil', 'not_found');
        }
    }

    public function timeoffApproval()
    {
        $data = RequestTimeoff::where('approve_by', Auth::user()->id)->with(['user', 'user.division', 'user.position', 'user.department', 'approveby', 'timeoff', 'attachment'])->oldest()->get();

        return $data;
    }

    public function overtimeApproval()
    {
        $data = Overtime::where('approve_by', Auth::user()->id)->with('user', 'user.division', 'user.position', 'user.department', 'approveby', 'attachment')->oldest()->get();

        return $data;
    }

    public function attendanceApproval()
    {
        $data = RequestAttendance::with('user', 'user.division', 'user.position', 'user.department', 'approveby', 'attachment')->where('approve_by', Auth::user()->id)->oldest()->get();
        foreach ($data as $value) {
            if ($value->clock_in && $value->clock_out) {
                $value->status = 'Clock in dan Clock out';
            } else {
                if ($value->clock_in) {
                    $value->status = 'Clock in';
                } else {
                    $value->status = 'Clock out';
                }
            }
        }
        return $data;
    }

    public function outofrangeApproval()
    {
        $data = RequestOutOfRange::where('approve_by', Auth::user()->id)->with(['user', 'user.division', 'user.position', 'user.department', 'approveby', 'attendance'])->get();

        $data = $data->map(function ($item, $key) {
            $item = collect($item)->toArray();
            if (array_key_exists('approval', $item)) {
                $item['approve'] = $item['approval'];
                unset($item['approval']);
            }
            return $item;
        });

        return $data;
    }

    public function vehicleborrowApproval()
    {
        $all_mobil = array();
        if (Auth::user()->can('approval-ga')) {
            if (Auth::user()->can('superadmin-ga')) {
                $data = BorrowVehicles::with('km_history', 'ga_approve', 'return_vehicles')->whereIn('status', [1, 2, 4, 3, 5])->where('approved', 1)->get();
            } else {
                $data = BorrowVehicles::whereIn('status', [1, 2, 4, 3, 5])
                    ->where('approved', 1)
                    ->whereHas('vehicles', function ($query) {
                        $query->whereHas('vehicle_pic', function ($picQuery) {
                            $picQuery->where('user_id', Auth::user()->id);
                        });
                    })
                    ->get();
            }

            foreach ($data as $narik_approve) {
                $is_ga = BorrowVehicles::find($narik_approve->id)->ga_approve;
                if (isset($is_ga)) {
                    $approve = $is_ga->status;
                    $narik_approve->approve = $approve;
                } else {
                    $narik_approve->approve = '0';
                }
            }
        } else {
            //selain GA by user id aja
            $data = BorrowVehicles::with('km_history', 'return_vehicles', 'return_vehicles')->where('owners', Auth::user()->id)->get();
        }

        foreach ($data as $y) {

            $is_ga = false;
            if (Auth::user()->can('approval-ga')) {
                $approve = $y->approve;
                $is_ga = true;
            } else {
                $approve = ($y->approved == 0) ? 0 : 1;
            }

            if (isset($y->attachment)) {
                $upload_file = [];
                foreach ($y->attachment as $x) {
                    $upload_file[] = $x->upload_file;
                }
            }

            $user = User::find($y->owners);
            $data_all = [
                'id' => $y->id,
                'vehicle' => array(
                    'vehicle_id' => $y->vehicles_id,
                    'vehicle_type' => $y->vehicles->type,
                    'vehicle_nopol' => $y->vehicles->no_polisi,
                ),
                'KM' => array(
                    'last_km' => $y->km_history->next_km ?? '-',
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
                'is_ga' => $is_ga,
                'reason' => $y->reason,
                'cost_center' => $y->cost_center,
                'request_date' => $y->request_date ?? '-',
                'approve' => $approve,
                'approval' => array(
                    'id' => $y->owners,
                    'status' => ($y->approved == 0) ? '0' : "$y->approved",
                    'head_name' => $user->name,
                    'approved_date' => $y->approved_date ?? '-',
                ),
                'approval_GA' => array(
                    'id' => $y->ga_approve->ga_approval_id ?? '-',
                    'status' => $y->ga_approve->status ?? '0',
                    'name' => $y->ga_approve->ga_pic->name ?? '-',
                    'GA_approved_date' => $y->ga_approve->approved_date ?? '-',
                ),
                'condition' => array(
                    'return_vehicles_id' => $y->return_vehicles->id ?? '-',
                    'body' => $y->return_vehicles->body ?? '-',
                    'lampu' => $y->return_vehicles->lampu ?? '-',
                    'ban' => $y->return_vehicles->ban ?? '-',
                    'ac' => $y->return_vehicles->ac ?? '-',
                    'mesin' => $y->return_vehicles->mesin ?? '-',
                    'description' => $y->return_vehicles->description ?? '-',
                    'last_position' => $y->return_vehicles->last_position ?? '-',
                    'upload_file' => $upload_file ?? '-',
                ),
                'updated_at' => $y->updated_at,
                'label' => 'mobil',
                'status_mobil' => $y->status,

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
        return $all_mobil;
    }

    public function approvalPengajuan(Request $req)
    {
        // dd($req);
        $types = ['timeoff', 'overtime', 'attendance', 'outofrange', 'vehicleborrow'];
        $data = [];
        if (in_array($req->type, $types)) {
            $items = $this->{$req->type . 'Approval'}();
            foreach ($items as $item) {
                $item['label'] = $req->type;
                $data[] = $item;
            }
        } else {
            foreach ($types as $type) {
                $items = $this->{$type . 'Approval'}();
                foreach ($items as $item) {
                    $item['label'] = $type;
                    $data[] = $item;
                }
            }
        }

        usort($data, function ($item1, $item2) {
            // First, sort by 'approve' in ascending order
            if ($item1['approve'] != $item2['approve']) {
                return $item1['approve'] <=> $item2['approve'];
            }
            // If 'approve' is the same, then sort by 'updated_at' in descending order
            return strtotime($item2['updated_at']) <=> strtotime($item1['updated_at']);
        });

        if (in_array($req->type, $types)) {
            return ResponseFormatter::success($data, 'Data pengajuan ' . $req->type . ' berhasil diambil');
        } else {
            return ResponseFormatter::success($data, 'Data pengajuan membutuhkan persetujuan berhasil diambil');
        }
    }

    public function countApprovalPengajuan()
    {
        $types = ['timeoff', 'overtime', 'attendance', 'outofrange', 'vehicleborrow'];
        $countData = [];
        foreach ($types as $type) {
            $items = $this->{$type . 'Approval'}();
            $count = 0;
            foreach ($items as $item) {

                if (isset($item['status_mobil'])) {
                    if (Auth::user()->can('approval-ga')) {
                        if (in_array($item['status_mobil'], [1, 4])) {
                            $count++;
                        }
                    } else {
                        if (in_array($item['status_mobil'], [0])) {
                            $count++;
                        }
                    }
                } else {
                    if ($item['approve'] == 0) {
                        $count++;
                    }
                }
            }
            $countData[$type] = $count;
        }

        return ResponseFormatter::success($countData, 'Jumlah pengajuan yang belum diapprove');
    }
}

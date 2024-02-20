<?php

namespace App\Http\Controllers\api;

use App\Helpers\ImageIntervention;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use Exception;
use App\Models\Attendances;
use App\Models\RequesAttendanceAttachment;
use App\Models\RequestAttendance;
use App\Models\User;
use App\Models\RequestOutOfRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class AttendanceController extends Controller
{
    function hitung_koordinat($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000; // radius dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $R * $c;
        return $distance;
    }

    public function is_within_radius($lat1, $lon1, $lat2, $lon2, $radius)
    {
        $distance = $this->hitung_koordinat($lat1, $lon1, $lat2, $lon2);
        return $distance <= $radius;
    }

    public function cekCordinate(Request $request)
    {
        $location = Auth::user()->location;
        $center = [(float)$location->latitude, (float)$location->longitude];
        $radius = Auth::user()->location->radius;
        if ($this->is_within_radius((float)$request->latitude, (float)$request->longitude, $center[0], $center[1], $radius)) {
            return ResponseFormatter::success(
                '',
                'Anda berada dalam radius'
            );
        } else {
            return ResponseFormatter::status('', 'Anda berada di luar radius', 'out_of_range');
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png',
            'type' => 'required'
        ]);
        $approval_line = Auth::user()->approval_line_id;

        // Extract relevant request data
        $date_time = date('Y-m-d H:i', strtotime($request->date_time));
        $user_id = Auth::user()->id;

        $user_shift = new User();
        $date_time_subs = $request->date_time;
        $date_subs = Carbon::createFromFormat('Y-m-d H:i:s.v', $date_time_subs)->subDay();
        $shift_back = $date_subs->format('Y-m-d');

        //cek dulu shift kemarin case dum malam
        $shift = $user_shift->getshifttoday(Auth::id(), $shift_back);
        $data = $shift->original['data'];
        $name = $data->Shift->name;

        // dd($request->all());
        //if belum update profile
        if (empty(Auth::user()->photo_path)) {
            return ResponseFormatter::status(
                (string) $date_time,
                'Update Photo Profile !',
                'belum_update_photo'
            );
        }
        // if dia bellum update karyawan dum
        if (Auth::user()->is_updated == 0 && Auth::user()->organization_id == 10) {
            return ResponseFormatter::status(
                (string) $date_time,
                'something went wrong',
                'belum_update_dum'
            );
        }

        if ($name == 'DUM MALAM') {
            // klo kemarin dum malam tetep pake shift kemarin
            $date_time_out = $date_subs;
            if ($request->type === 'clock_in') {
                $just_date_out = date('Y-m-d', strtotime($date_time));
            } else {
                $just_date_out = $shift_back;
            }
            $actual_date_out = $date_time;
            $status = '1';
            $shift_id = $data->Shift->id;
        } else {
            //klo bukan override shift baru
            $date_time_out = $date_time;
            $just_date_out = date('Y-m-d', strtotime($date_time));
            $shift_today = $user_shift->getshifttoday(Auth::id(), $just_date_out);
            $data_today = $shift_today->original['data'];
            $shift_id = $data_today->Shift->id;
            $status = '0';
        }

        //start attendance
        if ($request->type === 'clock_in') {
            $check_attendance_in = $this->check_attendance_in($just_date_out, $user_id, $status);
            if ($check_attendance_in) {
                return ResponseFormatter::status(
                    (string) $date_time,
                    'Anda sudah melakukan check in sebelumnya',
                    'already_check_in'
                );
            }
            if ($request->status_range == '0' || Auth::user()->is_boss == '1') {
                //dalam jangkauan
                $attendance = Attendances::whereDate('check_out', $just_date_out)->where('user_id', $user_id)->first();
                if (!$attendance) {
                    $attendance = new Attendances;
                    $attendance->user_id = $user_id;
                    $attendance->shift_id = $shift_id;
                }
                $attendance->check_in = $date_time;
                $attendance->img_check_in = ImageIntervention::compress($request->image, 'live_attendance');
                $attendance->longitude_in = $request->longitude;
                $attendance->latitude_in = $request->latitude;
                $attendance->description_in = $request->description;
                $attendance->live_absen_in = $request->status_range;
                $attendance->save();
                return ResponseFormatter::success(
                    (string) $attendance->check_in,
                    'Berhasil Check-in'
                );
            } else {
                $this->createOutOfRangeRequest('in', $user_id, $request, $approval_line, $date_time, $request->image);
                return ResponseFormatter::success((string) $request->date_time, 'Need Approval out of range');
            }
        }
        //checkout
        if ($request->type === 'clock_out') {
            $check_attendance_out = $this->check_attendance_out($just_date_out, $user_id, $status);
            if ($check_attendance_out) {
                return ResponseFormatter::status(
                    (string) $date_time,
                    'Anda sudah melakukan check out sebelumnya',
                    'already_check_out'
                );
            }
            if ($request->status_range == '0' || Auth::user()->is_boss == '1') {
                $attendance = Attendances::whereDate('check_in', $just_date_out)->where('user_id', $user_id)->first();
                if (!$attendance) {
                    $attendance = new Attendances;
                    $attendance->user_id = $user_id;
                    $attendance->shift_id = $shift_id;
                }
                $attendance->check_out = $date_time_out;
                if (isset($actual_date_out)) {
                    $attendance->actual_check_out = $actual_date_out;
                }
                $attendance->img_check_out = ImageIntervention::compress($request->image, 'live_attendance');
                $attendance->longitude_out = $request->longitude;
                $attendance->latitude_out = $request->latitude;
                $attendance->live_absen_out = $request->status_range;
                $attendance->description_out = $request->description;
                $attendance->save();
                return ResponseFormatter::success(
                    (string) $attendance->check_out,
                    'Berhasil Check-out'
                );
            } else {
                $this->createOutOfRangeRequest('out', $user_id, $request, $approval_line, $date_time_out, $request->image);
                return ResponseFormatter::success((string) $request->date_time, 'Need Approval out of range');
            }
        }
    }

    private function createOutOfRangeRequest($type, $user_id, $request, $approval_line, $date_time, $image)
    {
        $user = User::find(Auth::user()->approval_line_id);
        $nik = $user->nik;
        $oor = new RequestOutOfRange;
        $oor->type = $type;
        $oor->user_id = $user_id;
        $oor->longitude = $request->longitude;
        $oor->latitude = $request->latitude;
        $oor->image = ImageIntervention::compress($image, 'live_attendance');
        $oor->description = $request->description;
        $oor->approve_by = $approval_line;
        $oor->request_date = $date_time;
        $oor->save();
        $user->sendNotification($nik, Auth::user()->name, "Need your approval for out of range attendance request 🙏🏼", "approval");
    }

    public function AttendanceRequest(Request $request, User $user)
    {
        $approval = Auth::user()->approval_line_id;
        $atasan = $user->find($approval);
        try {
            if ($request->clock_in) {
                $clock_in = $request->clock_in;
            } else {
                $clock_in = null;
            }

            if ($request->clock_out) {
                $clock_out = $request->clock_out;
            } else {
                $clock_out = null;
            }
            $data = RequestAttendance::create([
                'user_id' => Auth::user()->id,
                'selected_date' => $request->selected_date,
                'request_date' => date('Y-m-d H:i', strtotime($request->date_time)),
                'clock_in' => $clock_in,
                'clock_out' => $clock_out,
                'description' => $request->description,
                'approve_by' => $approval
            ]);

            if ($request->upload_file) {
                foreach ($request->upload_file as $value) {
                    $m = new RequesAttendanceAttachment();
                    $m->request_attendances_id = $data->id;
                    $m->upload_file = ImageIntervention::compress($value, 'request_attendance');
                    $m->save();
                }
            }
            $user->sendNotification($atasan->nik, Auth::user()->name, "Need your approval for attendance request at $request->selected_date 🙏🏼", "approval");
            return ResponseFormatter::success(
                $data,
                'form request attendance has sent'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => (string)$error->getMessage(),
            ], 'Something went wrong', 500);
        }
    }

    public function check_attendance_in($just_date_out, $user_id, $status)
    {
        if ($status == '1') {
            return Attendances::whereDate('check_in', $just_date_out)
                ->where('user_id', $user_id)
                ->where('live_absen_in', '0')
                ->first();
        } else {
            return Attendances::whereDate('check_in', $just_date_out)
                ->where('user_id', $user_id)
                ->where('live_absen_in', '0')
                ->first();
        }
    }

    public function check_attendance_out($just_date_out, $user_id, $status)
    {
        if ($status == '1') {
            return Attendances::whereDate('check_out', $just_date_out)
                ->where('user_id', $user_id)
                ->where('live_absen_out', '0')
                ->first();
        } else {
            return Attendances::whereDate('check_out', $just_date_out)
                ->where('user_id', $user_id)
                ->where('live_absen_out', '0')
                ->first();
        }
    }

    public function showDetail($id)
    {
        $data = Attendances::findOrFail($id);
        return ResponseFormatter::success($data, 'Data Attendances user berhasil diambil');
    }


    public function fetch(Request $request)
    {
        $data = Attendances::where('user_id', Auth::user()->id)->whereMonth('check_in', $request->month)->get();
        foreach ($data as $x) {
            if ($x->live_absen_in != 0) {
                $x->check_in = null;
            }
            if ($x->live_absen_out != 0) {
                $x->check_out = null;
            }
        }
        return ResponseFormatter::success(
            $data,
            'success'
        );
    }

    public function countTimeoff($userId)
    {
        $now = Carbon::now();
        $absent = Attendances::whereYear('check_in', $now->year)->where('user_id', $userId)->get();
        $data = ImageIntervention::countTimeoff($absent);
        return ResponseFormatter::success(
            $data,
            'success'
        );
    }

    public function countTimeoffAllUser()
    {
        $query = User::query();

        return DataTables::of($query)
            ->addColumn('timeoff', function ($user) {
                $now = Carbon::now();
                $absent = Attendances::whereYear('check_in', $now->year)
                    ->where('user_id', $user->id)
                    ->get();
                return ImageIntervention::countTimeoff($absent);
            })
            ->editColumn('name', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('nik', function ($user) {
                return $user->nik;
            })
            ->toJson();
    }

}

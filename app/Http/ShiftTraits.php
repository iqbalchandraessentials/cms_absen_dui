<?php

namespace App\Http;

// use App\Models\Student;
use Exception;
use App\Helpers\ResponseFormatter;
use App\Models\Attendances;
use App\Models\cuti_tahunan;
use App\Models\Holiday;
use App\Models\Rosters;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

trait ShiftTraits
{
    public static function apiWithoutKey($year)
    {
        $client = new Client(); //GuzzleHttp\Client
        for ($i = 1; $i <= 12; $i++) {
            $url = 'https://api-harilibur.vercel.app/api?month=' . $i . '&year=' . $year . '';


            $response = $client->request('POST', $url, [
                'verify'  => false,
            ]);
            $responseBody = json_decode($response->getBody(), true); // Convert stdClass to array
            foreach ($responseBody as $holiday) {
                Holiday::create($holiday);
            }
        }
        return $holiday;
        // return view('projects.apiwithoutkey', compact('responseBody'));
    }

    public static function attendances($month, $year, $user_id)
    {
        $attendance = Attendances::where(function ($query) use ($month, $year, $user_id) {
            $query->whereMonth('check_in', $month)
                ->whereYear('check_in', $year)
                ->where('user_id', $user_id);
        })->orWhere(function ($query) use ($month, $year, $user_id) {
            $query->whereMonth('check_out', $month)
                ->whereYear('check_out', $year)
                ->where('user_id', $user_id);
        })
            //       ->orWhere(function ($query) use ($month, $year, $user_id) {
            //           $query->whereMonth('actual_check_out', $month)
            //                 ->whereYear('actual_check_out', $year)
            //                 ->where('user_id', $user_id);
            //     })
            ->get();

        foreach ($attendance as $x) {
            if (isset($x->check_in)) {
                $date_checkin = Carbon::parse($x->check_in)->format('Y-m-d');
                $x->date_check_in = $date_checkin;
            } else {
                $x->date_check_in = '-';
            }
            if (isset($x->check_out)) {
                $date_check_out = Carbon::parse($x->check_out)->format('Y-m-d');
                $x->date_check_out = $date_check_out;
            } else {
                $x->date_check_out = '-';
            }
            // if (isset($x->actual_check_out)) {
            //       $date_actual_check_out = Carbon::parse($x->actual_check_out)->format('Y-m-d');
            //       $x->date_actual_check_out = $date_actual_check_out;
            // } else {
            //       $x->date_actual_check_out = '-';
            // }
        }
        return $attendance;
    }

    public static function merged_shift($user_id, $month, $year)
    {
        $dates_shift = [];
        $start = "$year-$month-01";
        $end = "$year-12-31";
        $cek_rosters = Rosters::where('user_id', $user_id)->first();
        $startDate = Carbon::createFromFormat('Y-m-d', isset($cek_rosters) ? $start : "$year-01-01");
        $endDate = Carbon::createFromFormat('Y-m-d', $end);

        $data_shift = isset($cek_rosters) ? self::retrieveshift_dum($user_id, $start, $end) : self::retrieveshift($user_id, "$year-01-01", $end);
        $period_shift = new DatePeriod($startDate, new DateInterval('P1D'), $endDate->modify('+1 day'));
        foreach ($period_shift as $date) {
            $tanggal_period = $date->format('Y-m-d');
            if (!isset($data_shift[$tanggal_period])) {
                $data_shift[$tanggal_period] = [
                    "dates" => $tanggal_period,
                    "data_shift" => [
                        "id" => '-',
                        "name" => '-',
                        "schedule_in" => '-',
                        "schedule_out" => '-',
                    ],
                ];
            }
            array_push($dates_shift, $tanggal_period);
        }
        // dd($dates_shift);

        $merged = isset($cek_rosters) ? $data_shift : array_map(function ($date, $shift) {
            return [
                'dates' => $date,
                'data_shift' => isset($shift["data_shift"]) ? $shift["data_shift"] : null,
            ];
        }, $dates_shift, $data_shift);
        // dd($merged[364]);

        return $merged;
    }

    public static function retrieveshift_dum($user_id, $start, $end)
    {
        $data_shift = [];
        $dum_schedule = Rosters::where('user_id', $user_id)->whereBetween('date', [$start, $end])->get();
        // dd($dum_schedule);
        if ($dum_schedule->isEmpty()) {
            $data_shift[] = array(
                "dates" => '-',
                "data_shift" => array(
                    "id" => '-',
                    "name" => '-',
                    "schedule_in" => '-',
                    "schedule_out" => '-',
                )
            );
            // array_push($data_shift, $shift);
        } else {
            foreach ($dum_schedule as $x) {
                switch ($x['shift']) {
                    case "SIANG":
                        $shiftName = 'DUM PAGI';
                        break;
                    case "MALAM":
                        $shiftName = 'DUM MALAM';
                        break;
                    default:
                        $shiftName = 'dayoff';
                        break;
                }
                $cek_shift = Shift::where('name', $shiftName)->first();
                $data_shift[$x->date] =
                    array(
                        "dates" => $x->date,
                        "data_shift" => array(
                            "id" => $cek_shift->id,
                            "name" => $cek_shift->name,
                            "schedule_in" => $cek_shift->schedule_in,
                            "schedule_out" => $cek_shift->schedule_out,
                        )
                    );
            }
        }
        return $data_shift;
    }

    public static function retrieveshift($user_id, $start, $end)
    {
        $data_shift = array();
        $currentDate = Carbon::parse($start);
        $user_schedule = User::find($user_id);
        $data_avail = $user_schedule->available_schedules($currentDate)->first();
        $count_shift = Shift::where('schedule_id', $data_avail->schedule_id)->count();
        // $shiftIndex = 0; // Initialize the shift index
        $dayOfWeek = $currentDate->format('N');

        $shiftIndex = $dayOfWeek - 1;
        if ($shiftIndex == '0' && $count_shift < '8') {
            $shiftIndex = '7';
        } elseif ($shiftIndex == '0' && $count_shift > '7') {
            $shiftIndex = '14';
        } else {
            $shiftIndex;
        }

        while ($currentDate->lte($end)) {
            $data_schedule = $user_schedule->available_schedules($currentDate)->first();
            if ($data_schedule) {
                $shifts = Shift::where('schedule_id', $data_schedule->schedule_id)
                    ->orderBy('urutan', 'ASC')
                    ->get();

                if ($shifts->isEmpty()) {
                    // Handle no specific shifts for this schedule
                    $shift = array(
                        "name" => '-',
                        "schedule_in" => '-',
                        "schedule_out" => '-',
                    );
                } else {
                    // Calculate the shift index without considering schedule differences
                    $shiftIndex = $shiftIndex % $shifts->count();
                    $shift = $shifts[$shiftIndex];

                    // Increment the shift index for the next day
                    $shiftIndex++;

                    // Access shift data
                    $shift = array(
                        "id" => $shift->id,
                        "name" => $shift->name,
                        "schedule_in" => $shift->schedule_in,
                        "schedule_out" => $shift->schedule_out,
                        "urutan" => $shiftIndex,
                    );
                    // dd($shift);
                }
            } else {
                // Handle no schedule entry for this date
                $shift = array(
                    "id" => '-',
                    "name" => '-',
                    "schedule_in" => '-',
                    "schedule_out" => '-',
                );
            }

            array_push($data_shift, [
                // "dates" => $currentDate->toDateString(),
                "data_shift" => $shift,
            ]);

            // Compare the current date before incrementing and update if needed
            if ($data_schedule && $currentDate >= $data_schedule->end_date) {
                $currentDate = Carbon::parse($data_schedule->end_date)->addDay();
            } else {
                $currentDate->addDay();
            }
        }
        return $data_shift;
    }

    public static function getshiftrange($user_id, $start, $end, $dates)
    {
        $shift_today = array();
        $start_date = Carbon::createFromFormat('Y-m-d', $start);
        $end = Carbon::parse($end)->addDay(1)->format('Y-m-d');
        $month = $start_date->format('m');
        $year = $start_date->format('Y');
        $merged = self::merged_shift($user_id, $month, $year);
        foreach ($merged as $date) {
            if ($date['data_shift'] != null && $date['data_shift']['name'] == "dayoff") {
                if ($key = array_search($date['dates'], $dates)) {
                    unset($dates[$key]);
                }
            }
        }
        return $dates;
    }

    public static function getshifttoday($user_id, $tanggal, $only_shift = null, $return = null)
    {
        $shift_today = array();
        $date = Carbon::createFromFormat('Y-m-d', $tanggal);
        $month = $date->format('m');
        $year = $date->format('Y');
        $merged = self::merged_shift($user_id, $month, $year);
        if ($only_shift == null) {
            $cek_tanggal = self::attendances($month, $year, $user_id)->filter(function ($y) use ($tanggal) {
                return strstr($y->date_check_in, $tanggal) ||
                    strstr($y->date_check_out, $tanggal);
            });
            if (count($cek_tanggal) === 0) {
                $clock_in = '-';
                $clock_out = '-';
                $status = '-';
            } else {
                foreach ($cek_tanggal as $x) {
                    $clock_in = $x->check_in;
                    $clock_out = $x->check_out;
                    $status = $x->status;
                }
            }
        }
        foreach ($merged as $key => $x) {
            $date = $x['dates'];
            if ($date == $tanggal) {
                array_push($shift_today, $x['data_shift']);
            }
        }
        try {
            $oVal = (object)[
                'Shift' => (object)[
                    'id' => $shift_today['0']['id'],
                    'name' => $shift_today['0']['name'],
                    'schedule_in' => $shift_today['0']['schedule_in'],
                    'schedule_out' => $shift_today['0']['schedule_out'],
                ],
            ];
            if ($only_shift == null) {
                $oVal->log_absen = (object)[
                    'clock_in' => $clock_in,
                    'clock_out' => $clock_out,
                    'status' => $status
                ];
            }

            if (isset($return)) {
                return $oVal;
            } else {
                json_encode($oVal);
            }

            return ResponseFormatter::success($oVal, 'Pull shift success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Something went wrong', 500);
        }
    }

    public static function narik_libur($month, $year_req)
    {
        $start = Carbon::create()->day(1)->month($month)->year($year_req);
        $end = Carbon::create()->month($month)->year($year_req)->endOfMonth();

        $period = CarbonPeriod::create($start, $end);
        $user_id = Auth::id();
        $attendance = self::attendances($month, $year_req, $user_id);
        $data_attendance = [];
        foreach ($attendance as $item) {
            $cekin = $item->check_in ? $item->check_in : "-";
            $cekout = $item->check_out ? $item->check_out : "-";
            // $actual_check_out = $item->actual_check_out ? $item->actual_check_out : "-";

            array_push($data_attendance, (object)[
                'clock_in' => $cekin,
                'clock_out' => $cekout,
                // 'actual_check_out' => $actual_check_out,
            ]);
        }
        //narik schedule
        $merged = self::merged_shift($user_id, $month, $year_req);
        // dd($merged);
        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            $clock_in = "";
            $clock_out = "";
            // $actual_check_out = "";
            foreach ($data_attendance as $item) {
                $date_user_clock_in = explode(" ", $item->clock_in);
                $date_user_clock_out = explode(" ", $item->clock_out);
                // $date_user_actual_check_out = explode(" ", $item->actual_check_out);

                if ($tanggal == $date_user_clock_in[0] || $tanggal == $date_user_clock_out[0]) {
                    $clock_in = $item->clock_in;
                    $clock_out = $item->clock_out;
                    // $actual_check_out = $item->actual_check_out;
                    break;
                }
            }
            $all_dates[$tanggal] = array(
                "date" => $tanggal,
                "status" => "weekday",
                "attendance" => array(
                    "clock_in" => $clock_in,
                    "clock_out" => $clock_out,
                    // "actual_check_out" => $actual_check_out,
                ),
                "jadwal" => array(
                    "name" => "-",
                    "schedule_in" => "00:00",
                    "schedule_out" => "00:00",
                ),
                "description" => "-"
            );
        }
        $all_dates = self::holi_shift($start, $end, $all_dates, $merged);
        json_encode($all_dates);
        return $all_dates;
    }


    public static function log_absen($user_id, $month, $year)
    {
        $attend = self::attendances($month, $year, $user_id);
        $start = Carbon::create()->day(1)->month($month)->year($year);
        $end = Carbon::create()->month($month)->year($year)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);
        $merged = self::merged_shift($user_id, $month, $year);
        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            $status_absen_in = "";
            $status_absen_out = "";
            $status_absen = "";
            if ($attend->isNotEmpty()) {
                foreach ($attend as $item) {
                    $date_user_clock_in = explode(" ", $item->check_in);
                    $date_user_clock_out = explode(" ", $item->check_out);

                    if (isset($item->check_in)) {
                        $check_in = Carbon::parse($item->check_in)->format('H:i');
                    } else {
                        $check_in = "-";
                    }

                    if (isset($item->check_out)) {
                        $check_out = Carbon::parse($item->check_out)->format('H:i');
                    } else {
                        $check_out = "-";
                    }

                    $schedule_in = Carbon::parse($item->shift->schedule_in)->format('H:i');
                    $schedule_out = Carbon::parse($item->shift->schedule_out)->format('H:i');
                    $shift_name = $item->shift->name;

                    if (isset($item->overtime_after) || isset($item->overtime_before)) {
                        $overtime =  (int)$item->overtime_after + (int)$item->overtime_before;
                    } else {
                        $overtime = 0;
                    }
                    // if ($tanggal == $date_user_clock_in[0]) {
                    //     $edit = '<a href="' . route('edit.absensi', $item->id) . '">edit</a>';
                    // } else {
                    //     $edit = '-';
                    // }
                    if ($tanggal == $date_user_clock_in[0]) {
                        $edit = '<a href="' . route('report_absence.edit', $item->id) . '">edit</a>';
                    } else {
                        $edit = '-';
                    }
                    // $edit = '-';
                    if ($tanggal == $date_user_clock_in[0] || $tanggal == $date_user_clock_out[0]) {
                        if ($schedule_in >= $check_in) {
                            $status_absen_in = '<a target="_blank"   href="' . asset('uploads/live_attendance/' . $item->img_check_in) . '">' . $check_in . '</a>';
                        } else {
                            $status_absen_in = '<a target="_blank" style="color:red;"  href="' . asset('uploads/live_attendance/' . $item->img_check_in) . '">' . $check_in . '</a>';
                        }
                        $status_absen_out = '<a target="_blank" href="' . asset('uploads/live_attendance/' . $item->img_check_out) . '">' . $check_out . '</a>';
                        $status_absen = $item->status;
                        if ($item->status != "H") {
                            $status_absen = '<a href="' . route('time_off.show', $item->timeoff_id) . '" target="_blank">' . $item->status . '</a>';
                        }
                        break;
                    }
                }
            } else {
                $status_absen_in = '-';
                $status_absen_out = '-';
                $status_absen = '-';
                $schedule_in = '-';
                $schedule_out = '-';
                $shift_name = '-';
                $overtime = '-';
                $edit = '-';
                $status_absen = '-';
            }

            $all_dates[$tanggal] = array(
                "attendance" => array(
                    "clock_in" => $status_absen_in,
                    "clock_out" => $status_absen_out,
                    "status" => $status_absen,
                    "schedule_in" => $schedule_in,
                    "schedule_out" => $schedule_out,
                    "shift_name" => $shift_name,
                    "overtime" => $overtime,
                    "edit" => $edit,
                ),
                "status" => $status_absen,
                "date" => $tanggal,
            );
        }
        $okee = self::holi_shift($start, $end, $all_dates, $merged);
        return $okee;
    }

    public static function get_holiday($start, $end)
    {
        $holiday_data = Holiday::where('is_national_holiday', '1')->whereBetween('holiday_date', [$start, $end])->get();
        return $holiday_data;
    }

    public static function holi_shift($start, $end, $all_dates, $merged)
    {
        $holiday_data = self::get_holiday($start, $end);
        foreach ($holiday_data as $holiday) {
            $holiday_date = $holiday->holiday_date;
            $holiday_name = $holiday->holiday_name;
            if (array_key_exists($holiday_date, $all_dates)) {
                $all_dates[$holiday_date]['status'] = "holiday";
                $all_dates[$holiday_date]['description'] = $holiday_name;
            }
        }
        foreach ($merged as $x) {
            $date = $x['dates'];
            $shift = $x['data_shift'];
            // Check if the array value $x['data_shift'] is not null using isset()
            if (isset($shift)) {
                $data_shift = $shift['name'];
                $data_schedule_in = $shift['schedule_in'];
                $data_schedule_out = $shift['schedule_out'];

                if (array_key_exists($date, $all_dates)) {
                    if ($data_shift == 'dayoff') {
                        $all_dates[$date]['status'] = "weekend";
                    }
                    $all_dates[$date]['jadwal']['name'] = $data_shift;
                    $all_dates[$date]['jadwal']['schedule_in'] = $data_schedule_in;
                    $all_dates[$date]['jadwal']['schedule_out'] = $data_schedule_out;
                }
            } else {
                break;
            }
        }
        return $all_dates;
    }


    public static function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
        return $rangArray;
    }

    public static function kuota_cuti($user)
    {
        $user = User::find($user);

        if ($user->organization_id == 10) {
            $kuota_cuti =  $user->cuti_kuota->kuota_cuti;
        } else {
            $kuota_cuti =  $user->cuti_kuota->kuota_sisa + $user->cuti_kuota->kuota_cuti +  $user->cuti_kuota->adjustment;
        }
        return $kuota_cuti;
    }
}

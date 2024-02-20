<?php

namespace App\Exports;

use App\Models\Holiday;
use App\Models\Rosters;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use stdClass;

class AttendancesExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle
{
    protected $start_date;
    protected $end_date;
    protected $organization_id;

    function __construct($start_date, $end_date, $organization_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->organization_id = $organization_id;
    }

    public function view(): View
    {
        ini_set('max_execution_time', 180);
        $user_data = [];

        $period_date = array();
        if ($this->organization_id == 'all') {
            $organization_id = 0;
            // $narik_user = User::where('active', '1')->get();
            $users = User::with('schedules')->where('active', '1')->get();
        } else {
            $organization_id = $this->organization_id;
            // $narik_user = User::where('active', '1')->where('organization_id', $organization_id)->get();
            $users = User::with('schedules')->where('active', '1')->where('organization_id', $organization_id)->get();
        }
        $start_plus = Carbon::parse($this->start_date);
        $start_date = $start_plus->format('Y-m-d H:i');
        $end_plus = Carbon::parse($this->end_date);
        $end_plus->setTime(23, 59, 59);
        $end_date = $end_plus->format('Y-m-d H:i');

        $fill = DB::select('CALL narik_absen("' . $start_date . '", "' . $end_date . '","' . $organization_id . '")');
        //period
        $period = CarbonPeriod::create($start_date, $end_date);
        $groupedData = [];
        foreach ($users as $users_value) {
            $user_data[$users_value->id . '-1'] = $users_value->name;
        }

        // Loop through the original array and group by user_id
        foreach ($fill as $item) {
            $userId = $item->user_id . '-1';

            // Check if the user_id key exists in the grouped array
            if (!isset($groupedData[$userId])) {
                $groupedData[$userId] = [];
            }
            $groupedData[$userId][] = $item;
        }
        //narik user id
        foreach (array_keys($user_data) as $keyA) {
            if (!isset($groupedData[$keyA])) {
                $userId_sub = substr($keyA, 0, strpos($keyA, '-'));
                $groupedData[$userId_sub . '-2'] = [];
            }
        }

        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            array_push($period_date, $tanggal);
        }
        // dd($period_date);
        foreach ($groupedData as $key_awal => $userData) {
            $key = substr($key_awal, 0, strpos($key_awal, '-'));
            $itung_roster = $this->countRoster($key);
            $hasil_itung =  $itung_roster;
            $user = User::find($key);
            $newArray = [];
            foreach ($period_date as $date) {
                $dateFound = false;
                //ini harus jadi urutan
                foreach ($userData as $item) {
                    if ($item->date == $date) {
                        $newArray[] = $item;
                        $item->itung_roster = $hasil_itung;
                        $dateFound = true;
                        break;
                    }
                }
                if (!$dateFound) {
                    $placeholder = new stdClass();
                    $placeholder->date = $date;
                    $placeholder->date_in = "-";
                    $placeholder->date_out = "-";
                    $placeholder->user_id = $key;
                    $placeholder->name = $user->name;
                    $placeholder->nik = $user->nik;
                    $placeholder->organization_name = $user->organization->name;
                    $placeholder->division_name = $user->division->name;
                    $placeholder->department_name = $user->department->name;
                    $placeholder->job_level = $user->level->name;
                    $placeholder->job_position = $user->position->name;
                    $placeholder->lokasi = '-';
                    $placeholder->urutan = '-';
                    $placeholder->shift_name = '-';
                    $placeholder->schedule_in = '-';
                    $placeholder->schedule_out = '-';
                    $placeholder->id =  '-';
                    $placeholder->check_in = '-';
                    $placeholder->live_absen_in = '-';
                    $placeholder->img_check_in = '-';
                    $placeholder->check_out = '-';
                    $placeholder->live_absen_out = '-';
                    $placeholder->img_check_out = '-';
                    $placeholder->overtime_before = '-';
                    $placeholder->overtime_after = '-';
                    $placeholder->status = '-';
                    $placeholder->timeoff_id = '-';
                    $placeholder->TimeoffCode = '-';
                    $placeholder->itung_roster = $hasil_itung;
                    $newArray[] = $placeholder;
                }
            }
            $groupedData[$key_awal] = $newArray;
        }

        foreach ($groupedData as $key_kosong => $userData2) {
            $user_kosong = substr($key_kosong, 0, strpos($key_kosong, '-'));
            $penomoran =  substr($key_kosong, strpos($key_kosong, '-') + 1);
            if ($penomoran == '1') {
                // $check_schedule = $user->schedules()->first();
                // if (isset($check_schedule)) {
                    foreach ($userData2 as $urutan_check) {
                        if ($urutan_check->urutan === '-') {
                            if ($urutan_check->organization_name == 'PT. Diesel Utama Mineral' && $urutan_check->itung_roster == '1') {
                                $check_roster = $this->getRoster($urutan_check->user_id, $urutan_check->date);
                                $res_check = $this->getRosterStatus($check_roster);
                                $this->handleDayOff($urutan_check, $res_check);
                            } else {
                                $check_holiday = Holiday::whereDate('holiday_date', $urutan_check->date)->where('is_national_holiday', '1')->first();
                                if (isset($check_holiday)) {
                                    $urutan_check->shift_name = 'dayoff';
                                    $urutan_check->schedule_in = '00:00';
                                    $urutan_check->schedule_out = '00:00';
                                    $urutan_check->urutan = '-';
                                    $urutan_check->status = 'national holiday';
                                } else {
                                    $user = User::find($urutan_check->user_id);
                                    // Assuming $urutan_check->user_id is the user ID you want to check
                                    if ($user) {
                                        $schedule = $user->schedules()->whereDate('effective_date', '<=', $urutan_check->date)->whereDate('end_date', '>=', $urutan_check->date)->first();
                                        if ($schedule !== null) {
                                            $this->processNonDayOffUrutan($urutan_check, $userData2, $schedule);
                                        }
                                    }
                                }
                            }
                        }
                    }
                // }
            }
        }
        return view('reports.wo_daily', ['datas' => $groupedData, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    private function countRoster($userId)
    {
        $rosters =  Rosters::where('user_id', $userId)->first();
        return $rosters ? 1 : 0;
    }

    private function getRoster($userId, $date)
    {
        return Rosters::where('user_id', $userId)->where('date', $date)->first();
    }

    private function getRosterStatus($check_roster)
    {
        return isset($check_roster) ? [
            'shift' => $check_roster->shift,
            'off'   => $check_roster->off,
        ] : '-';
    }

    private function handleDayOff($urutan_check, $res_check)
    {
        if ($res_check != '-') {
            switch ($res_check['shift']) {
                case 'MALAM':
                    $urutan_check->shift_name = 'DUM MALAM';
                    $urutan_check->schedule_in = '18:00';
                    $urutan_check->schedule_out = '06:00';
                    $urutan_check->urutan = '-';
                    break;
                case 'SIANG':
                    $urutan_check->shift_name = 'DUM PAGI';
                    $urutan_check->schedule_in = '06:00';
                    $urutan_check->schedule_out = '18:00';
                    $urutan_check->urutan = '-';
                case '-':
                    if ($res_check['off'] == '1') {
                        $urutan_check->shift_name = 'dayoff';
                        $urutan_check->schedule_in = '00:00';
                        $urutan_check->schedule_out = '00:00';
                        $urutan_check->urutan = '-';
                    }
                    break;
                default:
                    $urutan_check->shift_name = '-';
                    $urutan_check->schedule_in = '-';
                    $urutan_check->schedule_out = '-';
                    $urutan_check->urutan = '-';
            }
        }
    }

    private function processNonDayOffUrutan($urutan_check, $userData2, $schedule)
    {
        // dd($urutan_check);
        // $urutan_now = null;
        $itung_schedule = Shift::where('schedule_id', $schedule->schedule_id)->count();
        $hasil = ($itung_schedule == '14' ? '14' : '7');

        if ($urutan_check->urutan === '-') {
            // echo "next";
            $nextIndex = array_search($urutan_check, $userData2) + 1;
            // dd($nextIndex);
            $next = $this->handleNextIndex($urutan_check, $userData2, $nextIndex, $schedule, $hasil);
            if (!isset($next)) {
                $beforeIndex = array_search($urutan_check, $userData2) - 1;
                $this->handleBeforeIndex($urutan_check, $userData2, $beforeIndex, $schedule, $urutan_check->urutan, $hasil);
            }
        }
    }

    private function handleNextIndex($urutan_check, $userData2, $nextIndex, $schedule, $hasil)
    {
        // $hasil = ($schedule == '14' ? '14' : '7');
        if (isset($userData2[$nextIndex])) {
            $urutan_now = $userData2[$nextIndex]->urutan;
            $urutan_fix = ($urutan_now == '1') ? $hasil : intval($urutan_check->urutan) - 1;
            $data_shift = $this->urutan_check($schedule, $urutan_fix);
            if (isset($data_shift)) {
                $this->setUrutanCheckData($urutan_check, $data_shift);
                return '1';
            }
        }
    }

    private function handleBeforeIndex($urutan_check, $userData2, $beforeIndex, $schedule, $urutan_now, $hasil)
    {
        if (isset($userData2[$beforeIndex])) {
            $urutan_now = $userData2[$beforeIndex]->urutan;
        }
        if (is_null($urutan_now)) {
            $urutan_fix = $hasil;
        } else {
            $urutan_fix = intval($urutan_now) + 1;
            $urutan_fix = ($urutan_fix > $hasil) ? 1 : $urutan_fix;
        }
        $data_shift = $this->urutan_check($schedule, $urutan_fix);
        $this->setUrutanCheckData($urutan_check, $data_shift);
    }

    private function setUrutanCheckData($urutan_check, $data_shift)
    {
        if (isset($data_shift)) {
            $urutan_check->shift_name = $data_shift->name;
            $urutan_check->schedule_in = $data_shift->schedule_in;
            $urutan_check->schedule_out = $data_shift->schedule_out;
            $urutan_check->urutan = $data_shift->urutan;
        }
        // dd($urutan_check);
    }

    public function urutan_check($schedule, $urutan)
    {
        return $data_shift = Shift::select('name', 'schedule_in', 'schedule_out', 'urutan')
            ->where('schedule_id', $schedule->schedule_id)->where('urutan', $urutan)
            ->first();
    }

    public function title(): string
    {
        return 'Reports';
    }
}

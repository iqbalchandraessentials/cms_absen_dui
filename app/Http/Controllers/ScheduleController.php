<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Helpers\ResponseFormatter;
use App\Imports\JadwalImport;
use App\Models\Department;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Timeoff;
use App\Models\User;
use App\Models\user_schedules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{

    public function index()
    {
        $data = schedule::with('user_schedule')->get();

        return view('schedule.index', ['data' => $data]);
    }

    public function dataControl($data)
    {
        $now = Carbon::now()->addDay(1);
        $result = [];
        foreach ($data as $value) {
            if ($value->user->active == 1) {
                $value->id = $value->user->id;
                $value->nik = $value->user->nik;
                $value->name = $value->user->name;
                $value->active = $value->user->active;
                $value->department = cekKosong($value->user->department);
                $value->location = cekKosong($value->user->location);
                $value->position = cekKosong($value->user->position);
                $value->organization = cekKosong($value->user->organization);
                if ($now->between($value->effective_date, $value->end_date)) {
                    array_push($result, $value);
                }
            }
        }
        return $result;
    }

    public function show($id)
    {
        function cekKosong($value)
        {
            if ($value == null) {
                return '-';
            } else {
                return $value->name;
            }
        }

        $data = Schedule::find($id);
        $user_not = user_schedules::get();

        $fill = $this->dataControl($data->user_schedule);
        $userNot = $this->dataControl($user_not);


        return view('schedule.show', ['data' => $data, 'employee' => $fill, 'all' => $userNot]);
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new JadwalImport, request()->file('file'));

        // notifikasi dengan session
        Session::flash('sukses', 'Schedule has successfully import');

        // alihkan halaman kembali
        return redirect(route('schedule.index'));
    }


    public function create()
    {
        return view('schedule.create');
    }


    public function export_excel(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
            'organization_id' => 'required',
        ]);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $download = Excel::download(new AttendancesExport($startDate, $endDate, $request->organization_id), 'ReportAbsent-' . $startDate->format('M') . '.xlsx');
        return $download;
    }

    public function store(Request $request)
    {

        $schedule = Schedule::create([
            'name' => $request->name,
            'override_national_holiday' => 0,
            'override_company_holiday' => 0,
            'override_special_holiday' => 0,
            'flexible' => 0,
            'include_late' => 0,
        ]);
        $schedule_id = $schedule->id;
        foreach ($request->ShiftName as $key => $value) {
            $formattedKey = str_pad($key + 1, 2, '0', STR_PAD_LEFT);
            Shift::create([
                'name' => $value,
                'urutan' => $formattedKey,
                'schedule_id' => (int) $schedule_id,
                'schedule_in' => Carbon::parse($request->timeShiftIn[$key])->format('H:i'),
                'schedule_out' => Carbon::parse($request->timeShiftOut[$key])->format('H:i'),
                'break_start' => Carbon::parse($request->breakStart[$key])->format('H:i'),
                'break_end' => Carbon::parse($request->breakEnd[$key])->format('H:i'),
            ]);
        }
        return redirect(route('schedule.index'));
    }

    public function edit_shift($id)
    {
        $data = Shift::findOrFail($id);
        return view('schedule.edit_shift', ['data'=> $data]);
    }

    public function update_shift($id, Request $request)
    {
        $data = Shift::findOrFail($id);
        $data->update($request->all());
        return redirect(route('schedule.show', $data->schedule_id));
    }

    public function edit_schedule($id, Request $request)
    {
        $endDate = date('Y-m-d', strtotime('12/31'));
        $user = $request->user_id;
        $now = Carbon::now()->addDay(1);
        foreach ($user as $value) {
            $data = user_schedules::where('user_id', $value)->get()->last();
            $data->update([
                $data->end_date = $now,
            ]);

            user_schedules::create([
                'user_id' => $value,
                'schedule_id' => $id,
                'effective_date' => $now,
                'end_date' => $endDate,
            ]);
        }
        return redirect(route('schedule.show', $id));
    }

    public function shift(Request $request)
    {
        $data = Shift::create($request->all());
        return ResponseFormatter::success($data, 'shift has create');
    }

    public function shiftList()
    {
        $data = Auth::user()->schedule->shift;
        return ResponseFormatter::success($data, 'success');
    }

    public function scheduleList()
    {
        $data = Schedule::get();
        return ResponseFormatter::success($data, 'success');
    }

    public function schedule(Request $request)
    {
        $data = Schedule::create($request->all());
        return ResponseFormatter::success($data, 'schedule has create');
    }

    public function timeoff(Request $request)
    {
        $data = Timeoff::create($request->all());
        return ResponseFormatter::success($data, 'timeoff has create');
    }

    public function timeoffList()
    {
        $data = Timeoff::where('active', 1)->get();
        return ResponseFormatter::success($data, 'success');
    }

    public function locationList()
    {
        $data = Location::get();
        return ResponseFormatter::success($data, 'success');
    }

    public function location(Request $request)
    {
        $data = Location::create($request->all());
        return ResponseFormatter::success($data, 'location has create');
    }

    public function organizationList()
    {
        $data = Organization::get();
        return ResponseFormatter::success($data, 'success');
    }

    public function organization(Request $request)
    {
        $data = Organization::create($request->all());
        return ResponseFormatter::success($data, 'organization has create');
    }

    public function departmentList()
    {
        $data = Department::get();
        return ResponseFormatter::success($data, 'success');
    }

    public function department(Request $request)
    {
        $data = Department::create($request->all());
        return ResponseFormatter::success($data, 'department has create');
    }

    public function count(Request $request)
    {
        $user = User::find($request->user_id);
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $dates = $user->getBetweenDates($start, $end);
        $holiday = $user->get_holiday($start, $end);
        foreach ($holiday as $h) {
            if (isset($h)) {
                if ($key = array_search($h->holiday_date, $dates)) {
                    unset($dates[$key]);
                }
            }
        }
        $dates = $user->getshiftrange($user->id, date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date)), $dates);
        return ResponseFormatter::success(['jml_hari' => count($dates), 'date' => $dates], 'total hari kerja');
    }
}

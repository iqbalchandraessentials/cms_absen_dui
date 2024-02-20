<?php

namespace App\Http\Controllers;

use App\Helpers\ImageIntervention;
use App\Helpers\ResponseFormatter;
use App\Models\Attendances;
use App\Models\Department;
use App\Models\Division;
use App\Models\JobPosition;
use App\Models\KuotaCuti;
use App\Models\List_Employee;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Position;
use App\Models\RequestAttendance;
use App\Models\RequestOutOfRange;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Timeoff;
use App\Models\User;
use App\Models\user_schedules;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $department = Department::select('name')->get();
        $division = Division::select('name')->get();
        return view('employee.index', ['division' => $division, 'department' => $department]);
    }

    public function show($id)
    {
        $data = User::findorfail($id);
        $now = Carbon::now();
        $dataCuti = Attendances::whereYear('check_in', $now->year)->where('user_id', $id)->get();
        $cuti = ImageIntervention::countTimeoff($dataCuti);
        $limit = Timeoff::get();
        $user_schedule = user_schedules::where('user_id', $id)->get()->last();
        $shift = Shift::get();
        $schedule = Schedule::get();
        $location = Location::where('active', 1)->get();
        $department = Department::get();
        $division = Division::get();
        $organization = Organization::get();
        $position = Position::get();
        $jobposition = JobPosition::get();
        $approval_line = User::where('active', 1)->get();
        $data->department = $this->cekKosong($data->department);
        $data->division = $this->cekKosong($data->division);
        $data->level = $this->cekKosong($data->level);
        $data->manager = $this->cekKosong($data->manager);
        $data->location = $this->cekKosong($data->location);
        $data->position = $this->cekKosong($data->position);
        $data->organization = $this->cekKosong($data->organization);
        $data->approval_line = $this->cekKosong($data->approval_line);
        return view('employee.show', ['data' => $data, 'department' => $department, 'user_schedule' => $user_schedule, 'approval_line' => $approval_line, 'manager' => $approval_line, 'division' => $division, 'jobposition' => $jobposition, 'position' => $position, 'organization' => $organization, 'jadwal' => $schedule, 'locations' => $location, 'cuti' => $cuti, 'limit' => $limit, 'shift' => $shift]);
    }

    public function cekKosong($value)
    {
        if ($value == null) {
            return '-';
        } else {
            return $value->name;
        }
    }

    public function create()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $jml_by_month = User::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $urutan = User::select('order_month')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        $results = array();
        foreach ($urutan as $query) {
            $order_row = $query->order_month;
            array_push($results, $order_row);
        }
        if (empty($results)) {
            $max = 0;
        } else {
            $max = max($results);
        }
        if ($jml_by_month == '0') {
            $order_month = '1';
        } else {
            //ini ambil nilai max di kolom
            $order_month = $max + 1;
        }
        $department = Department::get();
        $division = Division::get();
        $location = Location::where('active', 1)->get();
        $organization = Organization::where('active', 1)->get();
        $position = Position::get();
        $jobposition = JobPosition::get();
        $approval_line = User::where('active', 1)->get();
        $manager = $approval_line;
        $schedule = Schedule::get();
        return view('employee.create', [
            'location' => $location,
            'organization' => $organization,
            'position' => $position,
            'jobposition' => $jobposition,
            'manager' => $manager,
            'approval_line' => $approval_line,
            'schedule' => $schedule,
            'department' => $department,
            'division' => $division,
            'order_month' => $order_month,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'photo_path.*' => 'mimes:jpeg,jpg,png,bmp',
            'nik' => 'required|unique:users,nik',
            'citizen_id' => 'required|min:10|unique:users,citizen_id',
            'email' => 'required|string|email|unique:users,email',
            'mobile_phone' => 'required|unique:users,mobile_phone',
            'name' => 'required',
            'gender' => 'required',
            'join_date' => 'required',
            'organization_id' => 'required',
            'birth_date' => 'required',
            'religion' => 'required',
            'location_id' => 'required',
            'approval_line_id' => 'required',
            'schedule_id' => 'required',
            'manager_id' => 'required',
            'job_level_id' => 'required',
            'department_id' => 'required',
            'job_position' => 'required',
            'status_employee' => 'required',
            'division_id' => 'required',
        ]);

        if ($request->same_as_citizen_id_address == 'on') {
            $resindtial_address = $request->citizen_id_address;
        } else {
            $resindtial_address = $request->resindtial_address;
        }
        $password = Hash::make('admin123');
        $user = User::create([
            'order_month' => $request->order_month,
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'mobile_phone' => $request->mobile_phone,
            'organization_id' => $request->organization_id,
            'location_id' => $request->location_id,
            'job_level_id' => $request->job_level_id,
            'division_id' => $request->division_id,
            'department_id' => $request->department_id,
            'job_position' => $request->job_position,
            'join_date' => $request->join_date,
            'end_date' => $request->end_date,
            'emergency_number' => $request->emergency_number,
            'emergency_name' => $request->emergency_name,
            'status_employee' => $request->status_employee,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'citizen_id_address' => $request->citizen_id_address,
            'resindtial_address' => $resindtial_address,
            'citizen_id' => $request->citizen_id,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'PKTP_status' => $request->ptkp_status,
            'religion' => $request->religion,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'approval_line_id' => $request->approval_line_id,
            'manager_id' => $request->manager_id,
            'grade' => $request->grade,
            'golongan' => $request->golongan,
            // 'nba_koperasi' => $request->nba_koperasi,
            'password' => $password,
            'active' => 1,
        ]);
        $this->createUserSchedule($user->id, $request->schedule_id);
        $this->createKuotaCuti($user->id);
        return redirect(route('employee.index'))->with('message', 'data has saved!');
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        if ($request->schedule_id) {
            $this->createUserSchedule($id, $request->schedule_id);
        };
        $user->update($request->all());
        return redirect(route('employee.show', $id));
    }

    public function createKuotaCuti($user_id)
    {
        $now = Carbon::now();
        $KuotaCuti = KuotaCuti::create([
            'user_id' => $user_id,
            'periode' => $now->year,
        ]);
    }

    public function createUserSchedule($user, $schedule_id)
    {
        $year = date('Y'); // Get the current year
        $firstDayOfYear = "$year-01-01";
        // if (1 == date('N')) {
        //     $monday = time();
        // } else {
        //     $monday = Carbon::now()->startOfWeek();
        // }
        $endDate = date('Y-m-d', strtotime('12/31'));
        $now = Carbon::now();

        $update_schedule = user_schedules::where('user_id', $user)->get()->last();

        if ($update_schedule) {
            $update_schedule->end_date = $now;
            $update_schedule->save();
            $schedule = user_schedules::create([
                'user_id' => $user,
                'schedule_id' => $schedule_id,
                'effective_date' => $now->addDay(1),
                'end_date' => $endDate,
            ]);
        } else {
            $schedule = user_schedules::create([
                'user_id' => $user,
                'schedule_id' => $schedule_id,
                'effective_date' => Carbon::parse($firstDayOfYear),
                'end_date' => $endDate,
            ]);
        }
    }

    public function reset_password($id)
    {
        $password = Hash::make('admin123');
        $data = User::find($id);
        $data->update([
            'password' => $password
        ]);
        return redirect()->back()->with('message', 'password has change to default password!');
    }

    public function updateProfilePicture(Request $request, $id)
    {
        $this->validate($request, [
            'photo_path' => 'mimes:jpeg,jpg,png,bmp'
        ]);
        $data = ImageIntervention::compress($request->photo_path, 'profile_images');
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'User not found'], 404);
        }
        $user->photo_path = $data;
        $user->save();
        return response()->json(['status' => true, 'message' => 'Profile picture updated successfully', 'photo_path' => $data]);
    }

    public function list_employee()
    {
        $Auth =  User::find(Auth::user()->id);
        if ($Auth->organization->name == "PT. Diesel Utama Indonesia") {
            $query = List_Employee::all();
        } else {
            $query = List_Employee::where('organization' , $Auth->organization->name);
        }

        return $this->listemployees($query);
    }

    public function filter_employees($status, $department, $division)
    {
        $authUser = User::find(auth()->user()->id);

        if ($authUser->organization->name === "PT. Diesel Utama Indonesia") {
            $query = List_Employee::query();
        } else {
            $query = List_Employee::where('organization', $authUser->organization->name);
        }

        if ($status != "9") {
            $query->where('active', $status);
        }
        if ($department != "0") {
            $query->where('departments', $department);
        }
        if ($division != "0") {
            $query->where('division', $division);
        }
        return $this->listemployees($query);
    }


    public function listemployees($query)
    {
        return Datatables::of(
            $query
        )->editColumn('nik', function ($row) {
            return '<span>' . $row->nik . '</span> <span class="id_row" style="display:none">' . $row->id . '</span>';
        })->editColumn('NAME', function ($row) {
            return $row->NAME . ($row->active == 1 ? '' : '❌');
        })->editColumn('status', function ($row) {
            return $row->status ?? '-';
        })->editColumn('join_date', function ($row) {
            return $row->join_date ?? '-';
        })->editColumn('resign_date', function ($row) {
            return $row->resign_date ?? '-';
        })->editColumn('job_position', function ($row) {
            return $row->job_position . '-'. $row->level ?? '-';
        })->editColumn('level', function ($row) {
            return $row->level ?? '-';
        })->editColumn('grade', function ($row) {
            return $row->grade ?? '-';
        })->editColumn('golongan', function ($row) {
            return $row->golongan ?? '-';
        })->editColumn('departments', function ($row) {
            return $row->departments ?? '-';
        })->editColumn('division', function ($row) {
            return $row->division ?? '-';
        })->editColumn('organization', function ($row) {
            return $row->organization ?? '-';
        })->editColumn('location', function ($row) {
            return $row->location ?? '-';
        })->editColumn('rekening', function ($row) {
            return $row->rekening ?? '-';
        })->rawColumns(['nik'])->toJson();
    }

    public function insight(Request $request, $user_id)
    {
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $user = User::find($user_id);
        $dates = $user->getBetweenDates($start, $end);
        $holiday = $user->get_holiday($start, $end);
        foreach ($holiday as $h) {
            if (isset($h)) {
                if ($key = array_search($h->holiday_date, $dates)) {
                    unset($dates[$key]);
                }
            }
        }
        $date = $user->getshiftrange($user->id, $start, $end, $dates);
        $count_late = 0;
        $not_absent = 0;

        foreach ($date as $x) {
            $fill = $user->getshifttoday($user->id, $x, null, 'return');
            $clock_in = isset($fill->log_absen->clock_in) && $fill->log_absen->clock_in != '-' ? Carbon::parse($fill->log_absen->clock_in)->format('H:i') : '-';
            $clock_out = isset($fill->log_absen->clock_out) && $fill->log_absen->clock_out != '-' ? Carbon::parse($fill->log_absen->clock_out)->format('H:i') : '-';

            if ($fill->log_absen->status == 'H') {
                if ($clock_in > $fill->Shift->schedule_in) {
                    $count_late++;
                }
            }
            if ($clock_in == '-') {
                $not_absent++;
            }
        }

        $attendanceCounts = Attendances::where('user_id', $user_id)
        ->whereBetween('check_in', [$start, $end])
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
        $data = (object) [
            'not_absent' => $not_absent ,
            'late' => $count_late,
            'sdsd' => $attendanceCounts['SDSD'] ?? 0,
            'ct'   => $attendanceCounts['CT'] ?? 0,
            'stsd' => $attendanceCounts['STSD'] ?? 0,
            'ul'   => $attendanceCounts['UL'] ?? 0,
        ];

    return ResponseFormatter::success($data, 'okee','');

    }

}

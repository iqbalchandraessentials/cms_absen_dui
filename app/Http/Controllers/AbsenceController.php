<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Attendances;
use App\Models\Organization;
use App\Models\RequestAttendance;
use App\Models\RequestOutOfRange;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Timeoff;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function index()
    {
        $today = Carbon::now();
        $employee = User::where('active', 1)->get();
        $shift = Shift::get();
        $list_timeoff = Timeoff::where('active', 1)->get();
        $organization = Organization::where('active', 1)->get();
        return view('absence.index', ['today' => $today->format('d-M-Y'), 'organization' => $organization, 'employee' => $employee, 'shift' => $shift, 'list_timeoff' => $list_timeoff]);
    }

    public function store(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'date' => 'required',
                    'check_in' => 'required',
                    'check_out' => 'required',
                    'user_id' => 'required',
                    'status' => 'required',
                    'shift_id' => 'required',
                ]
            );

            $check_in = Carbon::parse($request->date . $request->check_in);
            $check_out = Carbon::parse($request->date . $request->check_out);
            $cek = Attendances::where('user_id', $request->user_id)
                ->where(function ($query) use ($check_in) {
                    $query->whereDate('check_in', $check_in)
                        ->orWhereDate('check_out', $check_in);
                })->get()->last();

            if (isset($cek)) {
                return redirect(route('report_absence.index'))->with('message', 'cant save because selected date request attedance is already exist!');
            }

            Attendances::create(
                [
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'user_id' => $request->user_id,
                    'longitude_in' => 0,
                    'latitude_in' => 0,
                    'description_in' => 'create by admin',
                    'longitude_out' => 0,
                    'latitude_out' => 0,
                    'description_out' => 'create by admin',
                    'img_check_in' => 'create by admin',
                    'img_check_out' => 'create by admin',
                    'overtime_after' => $request->overtime_after,
                    'overtime_before' => $request->overtime_before,
                    'status' => $request->status,
                    'shift_id' => $request->shift_id
                ]
            );
            return redirect(route('report_absence.index'))->with('message', 'data has saved!');
        } catch (Exception $error) {
            return redirect(route('report_absence.index'))->with('message', 'data is not saved!');
        }
    }

    public function edit($id)
    {
        $data = Attendances::find($id);
        $shift = Shift::get();
        $data->check_in = Carbon::parse($data->check_in);
        if (isset($data->check_out)) {
            $data->check_out = Carbon::parse($data->check_out);
        } else {
            $data->check_out = Carbon::parse('00:00');
        }
        return view('absence.edit', ['data' => $data, 'shift' => $shift]);
    }

    public function update($id, Request $request)
    {

        try {
            $this->validate(
                $request,
                [
                    'check_in' => 'required',
                    'check_out' => 'required',
                    'shift_id' => 'required',
                ]
            );

            $check_in = Carbon::parse($request->date . $request->check_in);
            $check_out = Carbon::parse($request->date . $request->check_out);
            $data = Attendances::find($id);

            if ($data->img_check_in) {
                $img_check_in = $data->img_check_in;
            } else {
                $img_check_in = 'update_absensi';
            }

            if ($data->img_check_out) {
                $img_check_out = $data->img_check_out;
            } else {
                $img_check_out = 'update_absensi';
            }

            $data->update([
                'check_in' => $check_in,
                'check_out' => $check_out,
                'img_check_in' => $img_check_in,
                'shift_id' => $request->shift_id,
                'img_check_out' => $img_check_out,
                'live_absen_in' => $request->live_absen_in,
                'live_absen_out' => $request->live_absen_out,
                'overtime_after' => $request->overtime_after,
                'overtime_before' => $request->overtime_before,
                'status' => $request->status,
            ]);
            return redirect(route('report_absence.index'));
        } catch (Exception $error) {
            return redirect(route('report_absence.index'))->with('message', 'data is not saved!');
        }
    }

    public function destroy($id)
    {
        $item = Attendances::findOrFail($id);
        $item->delete();
        return redirect(route('report_absence.index'));
    }

    public function index_out_of_range()
    {
        return view('absence.out_of_rrange');
    }

    public function index_attendance()
    {
        return view('request-attendance');
    }

    public function admin_create($user_id, Request $request)
    {

        try {
            $this->validate(
                $request,
                [
                    'date' => 'required',
                    // 'check_in' => 'required',
                    // 'check_out' => 'required',
                    'status' => 'required',
                    'shift_id' => 'required',
                ]
            );

            $selected_date = $request->date;
            if ($request->check_in) {
                $checkIn = Carbon::parse($selected_date . $request->check_in);
            } else {
                $checkIn = null;
            }
            if ($request->check_out) {
                $checkOut = Carbon::parse($selected_date . $request->check_out);
            } else {
                $checkOut = null;
            }

            $shift = $request->shift_id;
            $data = Attendances::where('user_id', $user_id)->first();

            $existingAttendance = isset($checkIn) && isset($checkOut)
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


            if ($existingAttendance) {
                $clockIn = $existingAttendance->check_in;
                $clockOut = $existingAttendance->check_out;

                if (isset($checkIn) && !isset($checkOut)) {
                    $existingAttendance->check_in = $checkIn;
                    $existingAttendance->check_out = $clockOut;
                    $existingAttendance->description_in = $data->description_in;
                    $existingAttendance->img_check_in = 'create by admin';
                    $existingAttendance->live_absen_in = '0';
                }

                if (isset($checkOut) && !isset($checkIn)) {
                    $existingAttendance->check_out = $checkOut;
                    $existingAttendance->check_in = $clockIn;
                    $existingAttendance->description_out = $data->description_out;
                    $existingAttendance->img_check_out = 'create by admin';
                    $existingAttendance->live_absen_out = '0';
                }

                if (isset($checkOut) && isset($checkIn)) {
                    $existingAttendance->check_in = $checkIn;
                    $existingAttendance->check_out = $checkOut;
                    $existingAttendance->status = 'H';
                    $existingAttendance->user_id = $data->user_id;
                    $existingAttendance->shift_id = $shift;
                }

                $existingAttendance->save();
            } else {
                $newAttendance = new Attendances;
                $newAttendance->check_in = $checkIn;
                $newAttendance->check_out = $checkOut;
                $newAttendance->longitude_in = $data->longitude_in;
                $newAttendance->longitude_out = $data->longitude_out;
                $newAttendance->longitude_out = $data->longitude_out;
                $newAttendance->latitude_out = $data->latitude_out;
                $newAttendance->description_in = $data->description_in;
                $newAttendance->description_out = $data->description_out;
                $newAttendance->img_check_in = 'create by admin';
                $newAttendance->img_check_out = 'create by admin';
                $newAttendance->live_absen_in = '0';
                $newAttendance->live_absen_out = '0';
                $newAttendance->overtime_after = $request->overtime_after;
                $newAttendance->overtime_before = $request->overtime_before;
                $newAttendance->status = 'H';
                $newAttendance->user_id = $data->user_id;
                $newAttendance->shift_id = $shift;
                $newAttendance->save();
            }

            return redirect(route('employee.show', $user_id))->with('message', 'Data Has Saved!');
        } catch (Exception $error) {
            return redirect()->back()->with('message', 'Data Is Not Saved!');
        }
    }

    public function filter_req_attendance(Request $request)
    {
        $selected_date = $request->month_filter;
        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9) {
            $query = RequestAttendance::with('user');
        } else {
            $query = RequestAttendance::select('request_attendances.*');
            $query->join('users', 'request_attendances.user_id', '=', 'users.id')
                ->where('users.organization_id', $organizationId);
        }
        if ($selected_date) {
            $year = date('Y', strtotime($selected_date));
            $month = date('m', strtotime($selected_date));
            $query->whereYear('selected_date', $year)->whereMonth('selected_date', $month);
        } else {
            $currentMonth = now()->format('m');
            $query->whereMonth('selected_date', $currentMonth);
        }
        return $this->list_reqattendance($query);
    }

    public function filter_out_of_range(Request $request)
    {
        $selected_date = $request->month_filter;

        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9) {
            $query = RequestOutOfRange::with('user');
        } else {
            $query = RequestOutOfRange::select('request_outofrange.*');
            $query->join('users', 'request_outofrange.user_id', '=', 'users.id')
                ->where('users.organization_id', $organizationId);
        }

        if ($selected_date) {
            list($year, $month) = explode('-', $selected_date);
            $query->whereYear('request_date', $year)->whereMonth('request_date', $month);
        } else {
            $currentMonth = now()->format('m');
            $query->whereMonth('request_date', $currentMonth);
        }
        $query->orderBy('created_at')->get();

        return $this->list_out_of_range($query);
    }


    public function list_out_of_range($query)
    {

        return Datatables::of(
            $query
        )->editColumn('request_date', function ($row) {
            $request_date = date('Y-m-d H:i', strtotime($row->request_date));
            return $request_date;
        })->editColumn('nik', function ($row) {
            return '<a href="' . route('employee.show', $row->user->nik) . '">' . $row->user->nik . '</a>';
        })->editColumn('name', function ($row) {
            return $row->user->name;
        })->editColumn('organization', function ($row) {
            return $row->user->organization->name;
        })->editColumn('location', function ($row) {
            return "<a target='_blank' href=" . asset('uploads/live_attendance/' . $row->image) . ">  " . $row->user->location->name . "  </a>";
            ;
        })->editColumn('type', function ($row) {
            if ($row->type == "in") {
                $type = '
                <a href="https://www.google.com/maps/search/?api=1&query=' . $row->latitude . ',' . $row->longitude . '" target="_blank" rel="noopener noreferrer">
                    <span class="badge badge-primary">
                        In
                    </span>
                </a>';
            } else {
                $type = '
                <a href="https://www.google.com/maps/search/?api=1&query=' . $row->latitude . ',' . $row->longitude . '" target="_blank" rel="noopener noreferrer">
                    <span class="badge badge-danger">
                        Out
                    </span>
                </a>';
            }

            return $type;
        })->editColumn('status', function ($row) {
            if ($row->approval == 0) {
                $status = '<span class="badge w-100 badge-warning">Pending</span>';
            } elseif ($row->approval == 1) {
                $status = '<span class="badge w-100 badge-success">Approved</span>';
            } elseif ($row->approval == 2) {
                $status = '<span class="badge w-100 badge-danger">Rejected</span>';
            } elseif ($row->approval == 3) {
                $status = '<span class="badge w-100 badge-secondary">Cancel</span>';
            }

            return $status;
        })->editColumn('approve_date', function ($row) {
            if (isset($row->approve_date)) {
                $approve_date = date('Y-m-d H:i', strtotime($row->approve_date));
            } else {
                $approve_date = '-';
            }
            return $approve_date;
        })->rawColumns(['nik', 'status', 'location', 'type'])->toJson();
    }


    public function list_reqattendance($query)
    {
        return Datatables::of(
            $query
        )->editColumn('request_date H:i', function ($row) {
            $request_date = date('Y-m-d', strtotime($row->request_date));
            return $request_date;
        })->editColumn('nik', function ($row) {
            return '<a href="' . route('employee.show', $row->user->id) . '">' . $row->user->nik . '</a>';
        })->editColumn('name', function ($row) {
            return $row->user->name;
        })->editColumn('organization', function ($row) {
            return $row->user->organization->name;
        })->editColumn('selected_date', function ($row) {
            return $row->selected_date ?? '-';
        })->editColumn('clock_in', function ($row) {
            if (isset($row->clock_in)) {
                $clock_in = date('Y-m-d | H:i', strtotime($row->clock_in));
            } else {
                $clock_in = '-';
            }
            return $clock_in;
        })->editColumn('clock_out', function ($row) {
            if (isset($row->clock_out)) {
                $clock_out = date('Y-m-d | H:i', strtotime($row->clock_out));
            } else {
                $clock_out = '-';
            }
            return $clock_out;
        })->editColumn('status', function ($row) {
            if ($row->approve == 0) {
                $status = '<span class="badge w-100 badge-warning">Pending</span>';
            } elseif ($row->approve == 1) {
                $status = '<span class="badge w-100 badge-success">Approved</span>';
            } elseif ($row->approve == 2) {
                $status = '<span class="badge w-100 badge-danger">Rejected</span>';
            } elseif ($row->approve == 3) {
                $status = '<span class="badge w-100 badge-secondary">Cancel</span>';
            }

            return $status;
        })->editColumn('approve_date', function ($row) {
            if (isset($row->approve_date)) {
                $approve_date = date('Y-m-d H:i', strtotime($row->approve_date));
            } else {
                $approve_date = '-';
            }
            return $approve_date;
        })->rawColumns(['nik', 'status'])->toJson();
    }

    public function filter_Abesnt(Request $request)
    {
        $selected_date = $request->month_filter;

        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9) {
            $org_id = null;
        } else {
            $org_id = $organizationId;
        }
        if ($selected_date) {
            $today = Carbon::parse($request->month_filter . ' 00:00:00');
            $start_date = $today->format('Y-m-d H:i');
            $end_date = Carbon::parse($request->month_filter . '23:59:59');
            $query = DB::select('CALL narik_absen("' . $start_date . '", "' . $end_date . '","' . $org_id . '")');
        } else {
            $today = Carbon::now()->startOfDay();
            $start_date = $today->format('Y-m-d H:i');
            $end_date = Carbon::now()->endOfDay();
            $end_date = $end_date->format('Y-m-d H:i');
            $query = DB::select('CALL narik_absen("' . $start_date . '", "' . $end_date . '","' . $org_id . '")');
        }
        return $this->list_Abesnt($query);
    }

    public function filter_user_Abesnt(Request $request, User $user)
    {
        $user_id = $request->user_id;
        $selected_date = $request->month_filter;
        if ($selected_date) {
            $year = date('Y', strtotime($selected_date));
            $month = date('m', strtotime($selected_date));
            $query = $user->log_absen((string) $user_id, $month, $year);
        } else {
            $month = now()->format('m');
            $year = now()->format('Y');
            $query = $user->log_absen((string) $user_id, $month, $year);
        }
        return $this->list_user_Abesnt($query);
    }


    public function list_user_Abesnt($query)
    {
        return Datatables::of($query)
            ->editColumn('date', function ($row) {
                return $row['date'];
            })
            ->editColumn('clock_in', function ($row) {
                return $row['attendance']['clock_in'];
            })
            ->editColumn('clock_out', function ($row) {
                return $row['attendance']['clock_out'];
            })
            ->editColumn('overtime', function ($row) {
                return $row['attendance']['overtime'];
            })
            ->editColumn('edit', function ($row) {
                return $row['attendance']['edit'];
            })
            ->editColumn('status', function ($row) {
                return $row['status'];
            })
            ->editColumn('schedule_in', function ($row) {
                return $row['jadwal']['schedule_in'];
            })
            ->editColumn('schedule_out', function ($row) {
                return $row['jadwal']['schedule_out'];
            })
            ->editColumn('schedule_name', function ($row) {
                return $row['jadwal']['name'];
            })
            ->rawColumns(['clock_in', 'clock_out', 'edit', 'status'])
            ->toJson();
    }



    public function list_Abesnt($query)
    {
        return Datatables::of(
            $query
        )->editColumn('check_in', function ($row) {
            if ($row->status == "H") {
                $schedule_in = Carbon::parse($row->schedule_in)->format('H:i');
                if ($schedule_in >= $row->check_in) {
                    $clockin = '<a target="_blank"   href="' . asset('uploads/live_attendance/' . $row->img_check_in) . '">' . $row->check_in . '</a>';
                } else {
                    $clockin = '<a target="_blank" style="color:red;"  href="' . asset('uploads/live_attendance/' . $row->img_check_in) . '">' . $row->check_in . '</a>';
                }
            } else {
                $clockin = '-';
            }
            return $clockin;
        })->editColumn('check_out', function ($row) {
            if ($row->status == "H") {
                if (isset($row->img_check_out)) {
                    $clockout = '<a target="_blank" href="' . asset('uploads/live_attendance/' . $row->img_check_out) . '">' . $row->check_out . '</a>';
                } else {
                    $clockout = '-';
                }
            } else {
                $clockout = '-';
            }
            return $clockout;
        })->editColumn('nik', function ($row) {
            return '<a href="' . route('employee.show', $row->user_id) . '">' . $row->nik . '</a>';
        })->editColumn('name', function ($row) {
            return $row->name;
        })->editColumn('organization', function ($row) {
            return $row->organization_name;
        })->editColumn('status', function ($row) {
            if ($row->status != "H") {
                $status = '<a href="' . route('time_off.show', $row->timeoff_id) . '" target="_blank">' . $row->status . '</a>';
            } else {
                $status = $row->status;
            }
            return $status;
        })->editColumn('schedule_in', function ($row) {
            return $row->schedule_in;
        })->editColumn('schedule_out', function ($row) {
            return $row->schedule_out;
        })->editColumn('overtime', function ($row) {
            $overtime = (int) $row->overtime_before + (int) $row->overtime_after;
            return $overtime;
        })->editColumn('shift_name', function ($row) {
            return $row->shift_name;
        })->editColumn('edit', function ($row) {
            $edit = '<a href="' . route('report_absence.edit', $row->id) . '">edit</a>';
            return $edit;
        })->rawColumns(['nik', 'check_in', 'check_out', 'edit', 'status'])->toJson();
    }

    public function apiAbsensi(Request $request)
    {
        $employee = User::select('name')->where('active', 1)->get();
        $today = Carbon::parse($request->date . ' 00:00:00');
        $start_date = $today->format('Y-m-d H:i');
        $end_date = Carbon::parse($request->date . '23:59:59');
        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9) {
            $org_id = null;
        } else {
            $org_id = $organizationId;
        }
        $data = DB::select('CALL narik_absen("' . $start_date . '", "' . $end_date . '","' . $org_id . '")');
        $uniqueUsers = [];
        $timeoff = 0;
        foreach ($data as $item) {
            $userId = $item->user_id;
            if (!isset($uniqueUsers[$userId])) {
                $uniqueUsers[$userId] = $item;
            }
            if ($item->status !== 'H') {
                $timeoff++;
            }
        }
        $number_employee = $employee->count();
        $no_check_in = $number_employee - count($uniqueUsers);
        $absent = count($uniqueUsers);

        return ResponseFormatter::success([
            'today' => $today->format('Y-m-d'),
            'absent' => $absent,
            'timeoff' => $timeoff,
            'number_employee' => $number_employee,
            'no_check_in' => $no_check_in,
        ], 'okeee');
    }
}

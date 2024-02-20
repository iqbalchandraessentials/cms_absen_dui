<?php

namespace App\Http\Controllers\api;

use App\Exports\OvertimeExport;
use App\Helpers\ImageIntervention;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use Exception;
use App\Models\Overtime;
use App\Models\OvertimeAttachment;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeController extends Controller
{

    public function index()
    {
        return view('overtime.index');
    }

    public function show($id)
    {
        $data = Overtime::findOrFail($id);
        return view('overtime.show', ['data' => $data]);
    }

    public function store(Request $request, User $user)
    {
        $approval = Auth::user()->approval_line_id;
        $atasan = $user->find($approval);
        if (isset($request->overtime_duration_before) || isset($request->overtime_duration_after)) {
            try {
            $request->validate([
                'select_date' => ['required'],
                'upload_file.*' => 'mimes:jpeg,jpg,png',
                'date_time' => 'required',
            ]);

            $data = Overtime::create([
                'user_id' => Auth::user()->id,
                'request_date' => date('Y-m-d H:i',strtotime($request->date_time)),
                'selected_date' => $request->select_date,
                'overtime_duration_before' => $request->overtime_duration_before,
                'overtime_duration_after' => $request->overtime_duration_after,
                'description' => $request->description,
                'delegation_id' => $request->delegation_id,
                'approve_by' => Auth::user()->approval_line_id
            ]);
            if ($request->upload_file) {
                foreach ($request->upload_file as $value) {
                    $m = new OvertimeAttachment();
                    $m->overtime_id = $data->id;
                    $m->upload_file = ImageIntervention::compress($value, 'overtime');
                    $m->save();
                }
            }
            $user->sendNotification($atasan->nik, Auth::user()->name, "Need your approval for overtime request at $request->select_date 🙏🏼", "approval");
            return ResponseFormatter::success([
                'data' => $data,
            ], 'Form Overtime has sent');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => (string)$error->getMessage(),
            ], 'Something went wrong', 500);
        }

    } else {
        return ResponseFormatter::error([
            'error' => "duration after or duration before need to be filled"
        ], 'Something went wrong', 500);
    }
    }


    public function filter_req_overtime(Request $request)
    {
        $selected_date = $request->month_filter;

        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9)  {
            $query = Overtime::with('user');
        } else {
            $query = Overtime::select('overtimes.*');
            $query->join('users', 'overtimes.user_id', '=', 'users.id')
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
        $query->get();
        return $this->list_overtime($query);

    }

    public function list_overtime($query)
    {
        return Datatables::of(
            $query
        )->editColumn('request_date', function ($row) {
            $request_date = date('Y-m-d H:i', strtotime($row->request_date));
            return $request_date;
        })->editColumn('nik', function ($row) {
            return '<a href="' . route('employee.show', $row->user->id) . '">' . $row->user->nik . '</a>';
        })->editColumn('name', function ($row) {
            return $row->user->name;
        })->editColumn('organization', function ($row) {
            return $row->user->organization->name;
        })->editColumn('selected_date', function ($row) {
            return $row->selected_date ?? '-';
        })->editColumn('overtime_duration_after', function ($row) {
            return $row->overtime_duration_after;
        })->editColumn('overtime_duration_before', function ($row) {
            return $row->overtime_duration_before;
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

    public function export_excel(Request $request)
	{
		$this->validate($request, [
			'start_date' => 'required',
			'end_date' => 'required',
		]);

        $startDate = date("Y-m-d", strtotime($request->start_date));
        $endDate = date("Y-m-d", strtotime($request->end_date));

        $download = Excel::download(new OvertimeExport($startDate, $endDate), 'ReportOvertime-'.$startDate.'-'.$endDate.'.xlsx');
        return $download;
	}

}

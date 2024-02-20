<?php

namespace App\Http\Controllers;

use App\Exports\KuotaCutiExport;
use App\Exports\TimeoffExport;
use App\Helpers\ImageIntervention;
use Exception;
use App\Helpers\ResponseFormatter;
use App\Models\RequestTimeoff;
use App\Models\RequestTimeoffAttachment;
use App\Models\Timeoff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\timeoffRequest;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TimeoffController extends Controller
{
    public function index()
    {
        return view('time_off.index');
    }

    public function show($id)
    {
        $data = RequestTimeoff::with(['delegation'])->find($id);
        if (isset($data->delegation)) {
            $data->delegation = $data->delegation->name;
        } else {
            $data->delegation = '-';
        }
        $data->now = Carbon::now();
        return view('time_off.show', ['data' => $data]);
    }

    public function store(timeoffRequest $request, User $user)
    {
        $date = Carbon::parse($request->start_date);
        $approval = Auth::user()->approval_line_id;
        $atasan = $user->find($approval);
        try {
            $tipe = Timeoff::find($request->timeoff_id);
            $request->validate([
                'timeoff_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'date_time' => 'required',
                'upload_file.*' => 'mimes:jpeg,jpg,png',
            ]);

            if ($tipe->attachment_mandatory == 1 && !isset($request->upload_file)) {
                return ResponseFormatter::status('data', 'file upload is required', 'error');
            }

            if (!isset($request->delegation_id) || empty($request->delegation_id) || is_null($request->delegation_id)) {
                $delegation_id = null;
            } else {
                $delegation_id = $request->delegation_id;
            }

            // jika diajukan cuti tahunan maka
            if ($request->timeoff_id == 1) {
                $cuti_kuota = Auth::user()->cuti_kuota;
                if (!isset($cuti_kuota)) {
                    return ResponseFormatter::status('data', 'Anda belum memiliki kuota cuti', 'error');
                }

                $dates = $user->getBetweenDates($request->start_date, $request->end_date);
                $holiday = $user->get_holiday($request->start_date, $request->end_date);
                foreach ($holiday as $h) {
                    if (isset($h)) {
                        if ($key = array_search($h->holiday_date, $dates)) {
                            unset($dates[$key]);
                        }
                    }
                }

                $dates = $user->getshiftrange(Auth::user()->id, date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date)), $dates);
                $kuotacuti = $user->kuota_cuti(Auth::user()->id);
                if (count($dates) > $kuotacuti) {
                    return ResponseFormatter::status('data', 'Kuota cuti tidak mencukupi', 'error');
                }
            }

            $data = RequestTimeoff::create([
                'user_id' => Auth::user()->id,
                'timeoff_id' => $request->timeoff_id,
                'request_date' => date('Y-m-d H:i', strtotime($request->date_time)),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'delegation_id' => $delegation_id,
                'approve_by' => Auth::user()->approval_line_id,
            ]);

            if ($request->has('upload_file')) {
                $attachments = [];
                foreach ($request->file('upload_file') as $file) {
                    $attachments[] = [
                        'request_timeoff_id' => $data->id,
                        'upload_file' => ImageIntervention::compress($file, 'timeoff'),
                    ];
                }
                RequestTimeoffAttachment::insert($attachments);
            }
            $user->sendNotification($atasan->nik, Auth::user()->name, "Need approval for Time Off request at {$date->format('d-M-Y')}", "approval");
            return ResponseFormatter::success(['data' => $data], 'Pengajuan cuti berhasil dibuat');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => (string) $error->getMessage()
            ], 'Something went wrong', 500);
        }
    }

    public function apiTimeoff(Request $req)
    {
        $dept_id = $req->dept_id;
        $date = $req->input('date');
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $data = RequestTimeoff::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get();

        if ($dept_id == 9) {
            $timeoff = $data;
        } else {
            $timeoff = [];
            foreach ($data as $value) {
                if ($value->user->organization_id != $dept_id) {
                    continue;
                }
                $timeoff[] = $value;
            }
        }
        foreach ($timeoff as $value) {
            $value->href = route("time_off.show", $value->id);
            $value->name = $value->user->name;
            $value->nik = $value->user->nik;
            $value->organization = $value->user->organization->name;
            $value->jenis_cuti = $value->timeoff->name;
            $value->created_date = date('d-M-Y', strtotime($value->created_at));
            $value->start_date = date('d-M-Y', strtotime($value->start_date));
            $value->end_date = date('d-M-Y', strtotime($value->end_date));
            if ($value->approve == 0) {
                $value->status = "<td>
                <i class='fas fa-exclamation-circle rounded-circle mr-1'
                style='color: #f1b53d'></i>
                Pending
                </td>";
            } else if ($value->approve == 1) {
                $value->status = "<td>
                <i class='fas fa-check-circle rounded-circle mr-1'
                style='color: rgb(36, 194, 57)'></i>
                Approved
                </td>";
            } else if ($value->approve == 2) {
                $value->status = "<td>
                <i class='fas fa-times-circle rounded-circle mr-1'
                        style='color: rgb(194, 36, 36)'></i>
                    Rejected
                </td>";
            } else if ($value->approve == 3) {
                $value->status = "<td>
                <i class='fas fa-times-circle rounded-circle mr-1'
                    style='color: rgb(18, 18, 18)'></i>
                    Canceled
                </td>";
            }
        }
        return ResponseFormatter::success([
            'timeoff' => $timeoff,
        ], 'okeee');
    }

    public function export_excel(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $startDate = date("Y-m-d", strtotime($request->start_date));
        $endDate = date("Y-m-d", strtotime($request->end_date));

        $download = Excel::download(new TimeoffExport($startDate, $endDate), 'Report Timeoff - ' . $startDate . '-' . $endDate . '.xlsx');
        return $download;
    }

    public function kuotaexport_excel()
    {
        $download = Excel::download(new KuotaCutiExport(), 'Report kuota Cuti tahunan - ' . Carbon::now() . '.xlsx');
        return $download;
    }

    public function filter_req_timeoff(Request $request)
    {
        $date = $request->month_filter;

        $organizationId = Auth::user()->organization_id;
        if ($organizationId == 9)  {
            $data = RequestTimeoff::with(['user', 'timeoff']);
        } else {
            $data = RequestTimeoff::select('request_timeoff.*');
            $data->join('users', 'request_timeoff.user_id', '=', 'users.id')
            ->where('users.organization_id', $organizationId);
        }

        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data->whereYear('start_date', $year)
                ->whereMonth('start_date', $month);
        } else {
            $currentMonth = now()->format('m');
            $data->whereMonth('start_date', $currentMonth);
        }

        $query = $data->get();
        return $this->list_req_timeoff($query);
    }


    public function list_req_timeoff($query)
    {
        return Datatables::of(
            $query
        )->editColumn('nik', function ($row) {
            return '<span>' . $row->user->nik . '</span> <span class="id_row" style="display:none">' . $row->id . '</span>';
        })->editColumn('name', function ($row) {
            return $row->user->name;
        })->editColumn('organization', function ($row) {
            return $row->user->organization->name;
        })->editColumn('created_date', function ($row) {
            return date('d-M-Y H:i', strtotime($row->created_at)) ?? '-';
        })->editColumn('time_off', function ($row) {
            return $row->timeoff->name ?? '-';
        })->editColumn('start_date', function ($row) {
            if (isset($row->start_date)) {
                $start_date = date('d-M-Y', strtotime($row->start_date));
            } else {
                $start_date = '-';
            }
            return $start_date;
        })->editColumn('end_date', function ($row) {
            if (isset($row->end_date)) {
                $end_date = date('d-M-Y', strtotime($row->end_date));
            } else {
                $end_date = '-';
            }
            return $end_date;
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


}

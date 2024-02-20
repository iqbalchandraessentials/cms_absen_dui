<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RosterImport;
use Exception;
use App\Models\Rosters;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class RosterController extends Controller
{
    public function index()
    {
        // $data = User::select([
        //     'users.id',
        //     'users.name',
        //     DB::raw('max(rosters.updated_at) as updated_at'),
        //     'users.division_id',
        //     'users.department_id',
        //     'users.job_position',
        //     'rosters.user_id'
        // ])->join('rosters', 'users.id', '=', 'rosters.user_id')
        //     ->groupBy('users.id', 'users.name', 'users.division_id', 'users.department_id', 'users.job_position', 'rosters.user_id')
        //     ->orderBy('updated_at', 'desc')
        //     ->get();


        return view('roster.import-roster');
    }

    public function import(Request $request)
    {
        try {
            // RawAbsen::query()->truncate();
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            Excel::import(new RosterImport($start_date, $end_date), request()->file('excel_file'));
            return redirect(route('roster'))->with('success', 'Data imported successfully!');
        } catch (Exception $e) {
            return redirect(route('roster'))->with('error', 'Error! Terdapat kesalahan pada format tamplate roster.');

        }
    }

    public function show($id)
    {
        $data = Rosters::where('user_id', $id)->get();
        return view('roster.show_roster', ['data' => $data]);
    }


    public function detail($id)
    {
        $data = Rosters::find($id);
        return view('roster.detail_roster', ['data' => $data]);
    }


    public function update($id, Request $request)
    {
        $off = $request->input('off');
        $cr = $request->input('cr');
        $ct = $request->input('ct');
        $induksi = $request->input('induksi');
        $data = Rosters::find($id);
        $data->update([
            $data->shift = $request->shift,
            $data->off = $off,
            $data->cr = $cr,
            $data->ct = $ct,
            $data->induksi = $induksi
        ]);

        return redirect(route('roster.show-roster', $data->user_id));
    }

    public function list_rosters()
    {
        $query = User::select([
            'users.id',
            'users.name',
            DB::raw('max(rosters.updated_at) as updated_at'),
            'users.division_id',
            'users.department_id',
            'users.job_position',
            'rosters.user_id'
        ])->join('rosters', 'users.id', '=', 'rosters.user_id')
            ->groupBy('users.id', 'users.name', 'users.division_id', 'users.department_id', 'users.job_position', 'rosters.user_id')
            ->orderBy('updated_at', 'desc')
            ->get();

        return $this->listrosters($query);
    }

    public function listrosters($query)
    {
        return DataTables::of(
            $query
        )->editColumn('name', function ($row) {
            return '<span>' . $row->name . '</span> <span class="id_row" style="display:none">' . $row->id . '</span>';
        })->editColumn('division', function ($row) {
            return $row->division->name;
        })->editColumn('department', function ($row) {
            return $row->department->name;
        })->editColumn('position', function ($row) {
            return $row->position->name;
        })->editColumn('updated_at', function ($row) {
            $updated_at = date('d-M-Y', strtotime($row->updated_at));
            return $updated_at;
        })->rawColumns(['name'])->toJson();
    }

    public function filter_jadwal_roster(Request $request, $id)
    {
        $data = Rosters::where('user_id', $id);
        $date = $request->month_filter;

        if ($date) {
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $data->whereYear('date', $year)
                ->whereMonth('date', $month);
        } else {
            $currentMonth = now()->format('m');
            $data->whereMonth('date', $currentMonth);
        }

        $query = $data->get();

        return $this->list_jadwal_roster($query);
    }

    public function list_jadwal_roster($query)
    {
        return DataTables::of(
            $query
        )->editColumn('date', function ($row) {
            return '<span>' . $row->date . '</span> <span class="id_row" style="display:none">' . $row->id . '</span>';
        })->editColumn('shift', function ($row) {
            return $row->shift;
        })->editColumn('off', function ($row) {
            if ($row->off == '0') {
                $off = '<span class="badge badge-danger">No</span>';
            } else {
                $off = '<span class="badge badge-success">Yes</span>';
            }
            return $off;
        })->editColumn('cr', function ($row) {
            if ($row->cr == '0') {
                $cr = '<span class="badge badge-danger">No</span>';
            } else {
                $cr = '<span class="badge badge-success">Yes</span>';
            }
            return $cr;
        })->editColumn('ct', function ($row) {
            if ($row->ct == '0') {
                $ct = '<span class="badge badge-danger">No</span>';
            } else {
                $ct = '<span class="badge badge-success">Yes</span>';
            }
            return $ct;
        })->editColumn('induksi', function ($row) {
            if ($row->induksi == '0') {
                $induksi = '<span class="badge badge-danger">No</span>';
            } else {
                $induksi = '<span class="badge badge-success">Yes</span>';
            }
            return $induksi;
        })->rawColumns(['date', 'off', 'cr', 'ct', 'induksi'])->toJson();
    }

}
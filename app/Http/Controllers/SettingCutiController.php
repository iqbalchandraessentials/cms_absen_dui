<?php

namespace App\Http\Controllers;

use App\Models\cuti_tahunan;
use App\Models\KuotaCuti;
use App\Models\Timeoff;
use App\Models\User;
use App\Imports\KuotaCutiImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SettingCutiController extends Controller
{

    public function index()
    {
        $now = Carbon::now();
        $cuti_tahunan = cuti_tahunan::where('name', $now->year)->first();
        $timeoff = Timeoff::get();
        $user = new User();
        $data = KuotaCuti::get();
        foreach ($data as $value) {
            $value->kuota_cuti = $user->kuota_cuti($value->user->id);
        }
        $token = session('token');
        return view('setting_timeoff.index', ['token' => $token, 'timeoff' => $timeoff, 'now' => $now, 'data' => $data, 'user' => $user->where('active', 1)->get(), 'cuti_tahunan' => $cuti_tahunan]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Timeoff::create($data);
        return redirect()->route('setting_time_off.index')->with('message', 'data has saved!');;
    }

    public function edit($id)
    {
        $data = Timeoff::find($id);
        return view('setting_timeoff.edit', ["data" => $data]);
    }

    public function update(Request $request, $id)
    {
        try{
            $data = Timeoff::find($id);
            $data->update($request->all());
            return redirect(route('setting_time_off.index'))->with('message', 'data has saved!');
        } catch (Exception $e) {
            return redirect(route('setting_time_off.index'))->with('error', 'Error! Terdapat kesalahan.' . $e->getMessage());
        }
    }

    public function mass_leave(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            Excel::import(new KuotaCutiImport, request()->file('file'));
            return redirect()->route('setting_time_off.index')->with('message', 'data has saved!');
        } catch (Exception $e) {
            return redirect(route('setting_time_off.index'))->with('error', 'Error! Terdapat kesalahan.' . $e->getMessage());
        }
    }

    public function list_timeoff()
    {
        $user = new User();
        $query = KuotaCuti::get();
        foreach ($query as $value) {
            $value->kuota_cuti = $user->kuota_cuti($value->user->id);
        }
        return $this->listTimeoff($query);
    }
    public function listTimeoff($query)
    {
        return DataTables::of(
            $query
        )->editColumn('nik', function ($row) {
            return '<a href="' . route('employee.show', $row->user->id) . '">' . $row->user->nik . '</a>';
        })->editColumn('name', function ($row) {
            return $row->user->name;
        })->editColumn('pt', function ($row) {
            return $row->user->organization->name;
        })->editColumn('kuota_cuti', function ($row) {
            return $row->kuota_cuti;
        })->editColumn('action', function ($row) {
            return "<a href='" . route('cuti-tahunan.edit', $row->id) . "'>Edit</a>";
        })->rawColumns(['nik', 'action'])->toJson();
    }
}

<?php

namespace App\Exports;

use App\Helpers\ImageIntervention;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeeExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = User::all();
        $data = ImageIntervention::userFormat($data);
        return view('reports.employee',['data'=>$data]);
    }

    public function title(): string
    {
        return 'Reports';
    }
}

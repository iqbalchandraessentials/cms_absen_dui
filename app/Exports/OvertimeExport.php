<?php

namespace App\Exports;

use App\Models\Overtime;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class OvertimeExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle
{

    protected $start_date;
    protected $end_date;

    function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }


    public function view(): View
    {
        $data = Overtime::where('selected_date', '>=', $this->start_date)->where('selected_date', '<=', $this->end_date)->get();
        return view('reports.lembur', ['datas' => $data, 'start_date' => $this->start_date, 'end_date' => $this->end_date]);
    }

    public function title(): string
    {
        return 'Reports';
    }
}

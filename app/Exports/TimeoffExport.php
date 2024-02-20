<?php

namespace App\Exports;

use App\Models\RequestTimeoff;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class TimeoffExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle
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
        $data = RequestTimeoff::where('created_at', '>=', $this->start_date)->where('created_at', '<=', $this->end_date)->get();
        return view('reports.timeoff', ['datas' => $data, 'start_date' => $this->start_date, 'end_date' => $this->end_date]);
    }

    public function title(): string
    {
        return 'Reports';
    }
}

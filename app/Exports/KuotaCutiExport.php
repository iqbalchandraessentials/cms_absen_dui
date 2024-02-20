<?php

namespace App\Exports;

use App\Models\KuotaCuti;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class KuotaCutiExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle
{

    public function view(): View
    {
        $data = KuotaCuti::get();
        return view('reports.reportCuti', ['data' => $data]);
    }

    public function title(): string
    {
        return 'Reports';
    }
}

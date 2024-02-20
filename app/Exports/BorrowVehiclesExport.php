<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\PinjamMobil\Entities\BorrowVehicles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class BorrowVehiclesExport implements FromView, ShouldAutoSize,  WithStrictNullComparison, WithTitle

{

    protected $start_date;
    protected $end_date;


    function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = BorrowVehicles::where('start_date', '>=', $this->start_date)->where('start_date', '<=', $this->end_date)->with('km_history')->get();
        return view('pinjammobil::borrow.export',['data'=>$data]);
    }

    public function title(): string
    {
        return 'Reports Borrow Vehicles';
    }
}

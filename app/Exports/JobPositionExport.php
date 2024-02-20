<?php

namespace App\Exports;

use App\Models\JobPosition;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobPositionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JobPosition::all();
    }
}

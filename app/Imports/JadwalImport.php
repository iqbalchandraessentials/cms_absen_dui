<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class JadwalImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // dd($row);
        return new Schedule([
            'name'=> $row[0],
            'effective_date'=> date('Y-m-d', strtotime($row[1])),
            'override_national_holiday'=> (int)$row[2],
            'override_company_holiday'=> (int)$row[3],
            'override_special_holiday'=> (int)$row[4],
            'flexible'=> (int)$row[5],
            'include_late'=> (int)$row[6],
            'shift_id'=> (int)$row[7],
            'initial_shift'=> (int)$row[8],
            'active'=> 0
        ]);
    }
}

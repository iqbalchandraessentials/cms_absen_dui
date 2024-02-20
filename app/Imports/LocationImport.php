<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LocationImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new Location([
            'name'=> $row[1],
            'location'=> $row[3],
            'latitude'=> $row[4],
            'longitude'=> $row[5],
            'radius'=> (int)$row[6],
        ]);
    }
}

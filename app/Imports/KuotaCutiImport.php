<?php

namespace App\Imports;

use App\Models\User;
use App\Models\KuotaCuti;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KuotaCutiImport implements ToModel, WithStartRow, WithValidation
{
    public function rules(): array
    {
        return [
            '0' => 'exists:users,nik',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.exists' => 'Please check NIK is not exists value.',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $user = User::where('nik', $row['0'])->first();

        if ($user) {
            // Use DB::raw to subtract the new value from the existing value
            KuotaCuti::where('user_id', $user->id)
                ->update([
                    'adjustment' => DB::raw("adjustment + {$row['1']}"),
                ]);
        }
    }
}

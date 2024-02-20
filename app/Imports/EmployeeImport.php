<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Division;
use App\Models\JobPosition;
use App\Models\KuotaCuti;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Schedule;
use App\Models\User;
use App\Models\user_schedules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeImport implements ToModel, WithStartRow, WithValidation
{

    public function rules(): array
    {
        return [
            '7' => 'exists:organizations,name',
            '8' => 'exists:locations,name',
            '9' => 'exists:divisions,name',
            '10' => 'exists:departments,name',
            '11' => 'exists:job_positions,name',
            '12' => 'exists:positions,name',
            '25' => 'exists:users,name',
            '26' => 'exists:users,name',
            '29' => 'exists:schedules,name',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '7.exists' => 'Please check Organization is not exists value.',
            '8.exists' => 'Please check Location is not exists value.',
            '9.exists' => 'Please check Division is not exists value.',
            '10.exists' => 'Please check Department is not exists value.',
            '11.exists' => ' Please check JobPosition is not exists value.',
            '12.exists' => ' Please check Position is not exists value.',
            '25.exists' =>  'Please check User Approval line is not exists value.',
            '26.exists' =>  'Please check User Manager is not exists value.',
            '29.exists' =>  'Please check Schedule is not exists value.',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $Organization = Organization::select('id')->where('name', $row['7'])->first();
        $Location = Location::select('id')->where('name', $row['8'])->first();
        $Division = Division::select('id')->where('name', $row['9'])->first();
        $Department = Department::select('id')->where('name', $row['10'])->first();
        $JobPosition = JobPosition::select('id')->where('name', $row['11'])->first();
        $Position = Position::select('id')->where('name', $row['12'])->first();
        $approval = User::select('id')->where('name', $row['25'])->first();
        $manager = User::select('id')->where('name', $row['26'])->first();
        $Schedule = Schedule::select('id')->where('name', $row['29'])->first();
        $password = Hash::make('admin123');
        $user = User::create(
            [
                'nik' => (int)$row[0],
                'name' => (string)$row[1],
                'mobile_phone' => $row[2],
                'citizen_id' => (int)$row[3],
                'religion' => $row[4],
                'gender' => $row[5],
                'marital_status' => $row[6],
                'organization_id' => $Organization,
                'location_id' => $Location,
                'division_id' => $Division,
                'department_id' => $Department,
                'job_position' => $JobPosition,
                'job_level_id' => $Position,
                'status_employee' => $row[13],
                'join_date' =>  date('Y-m-d', strtotime($row[14])),
                'end_date' => $row[15],
                'email' => $row[16],
                'birth_date' => date('Y-m-d', strtotime($row[17])),
                'birth_place' => $row[18],
                'citizen_id_address' => $row[19],
                'resindtial_address' => $row[20],
                'NPWP' => (int)$row[21],
                'PKTP_status' => $row[22],
                'bank_name' => $row[23],
                'bank_account' => $row[24],
                'approval_line_id' => $approval,
                'manager_id' => $manager,
                'grade' => (int)$row[27],
                'golongan' => $row[28],
                'schedule_id' =>$Schedule,
                'emergency_name' => $row[30],
                'emergency_number' => $row[31],
                'active' => 1,
                'password' => $password,
            ]
        );

        if (1 == date('N')) {
            $monday = time();
        } else {
            $monday = Carbon::now()->startOfWeek();
        }

        user_schedules::create([
            'user_id' => $user->id,
            'schedule_id' => $Schedule,
            'effective_date' => $monday,
            'end_date' => date('Y-m-d', strtotime('12/31')),
        ]);

        $now = Carbon::now();
        KuotaCuti::create([
            'user_id' => $user->id,
            'periode' => $now->year,
        ]);

        return $user;
    }
}

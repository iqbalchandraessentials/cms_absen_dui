<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Rosters;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RosterImport implements WithMultipleSheets
{
    protected $start_date;
    protected $end_date;
    function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function sheets(): array
    {
        return [
            new FirstSheetImport($this->start_date, $this->end_date)
        ];
    }
}

class FirstSheetImport implements ToCollection, WithStartRow
{
    protected $start_date;
    protected $end_date;

    function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection(Collection $rows)
    {
        $dates_shift = array();
        $all_dates = [];
        $begin = new DateTime($this->start_date);
        $end_schedule = new DateTime($this->end_date);
        $end_schedule->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period_shift = new DatePeriod($begin, $interval, $end_schedule);
        foreach ($period_shift as $x) {
            array_push($dates_shift, $x->format('Y-m-d'));
        }

        foreach ($rows as $row) {
            $collection = collect($row)->slice(4);
            // dd($collection);
            $count = $collection->count();
            $total = $count + 4;
            $shiftIndex = 4; // Counter variable to keep track of the current index in $collection

            foreach ($dates_shift as $x) {
                // Ensure that we don't go out of bounds of $collection
                if ($shiftIndex >= $total) {
                    break;
                }

                $shift = $collection[$shiftIndex];

                $all_dates[$x . '-' . $row[2]] = array(
                    "data" => array(
                        "unit" => $row[1],
                        "nik" => $row[2],
                    ),
                    "date" => $x,
                    "shift" => $shift
                );
                $shiftIndex++; // Increment the counter to move to the next shift value
            }
            // break;
        }
        // dd($all_dates);

        foreach ($all_dates as $x) {
            $unit_code = $x['data']['unit'];
            // $id_unit = Unit::select('id')->where('unit_code', $unit_code)->first();
            $nik = $x['data']['nik'];
            $id_user = User::select('id')->where('NIK', $nik)->first();
            // if ($id_user == null) {
            //     dd($nik);
            // }
            switch ($x['shift']) {
                case "DS":
                    $data = [
                        'shift' => "SIANG",
                        'off' => "0",
                        'cr' => "0",
                        'ct' => "0",
                        'induksi' => "0",
                    ];
                    break;
                case "NS":
                    $data = [
                        'shift' => "MALAM",
                        'off' => "0",
                        'cr' => "0",
                        'ct' => "0",
                        'induksi' => "0",
                    ];
                    break;
                case "OFF":
                    $data = [
                        'shift' => "-",
                        'off' => "1",
                        'cr' => "0",
                        'ct' => "0",
                        'induksi' => "0",
                    ];
                    break;
                case "CR":
                    $data = [
                        'shift' => "-",
                        'off' => "0",
                        'cr' => "1",
                        'ct' => "0",
                        'induksi' => "0",
                    ];
                    break;
                case "CT":
                    $data = [
                        'shift' => "-",
                        'off' => "0",
                        'cr' => "0",
                        'ct' => "1",
                        'induksi' => "0",
                    ];
                    break;
                case "IN":
                    $data = [
                        'shift' => "-",
                        'off' => "0",
                        'cr' => "0",
                        'ct' => "0",
                        'induksi' => "1",
                    ];
                    break;
                default:
                    echo "Your favorite color is neither red, blue, nor green!";
            }
            Rosters::updateOrCreate(
                ['user_id' => $id_user->id, 'date' => $x['date']],
                [
                    'shift' => $data['shift'],
                    'off' => $data['off'],
                    'cr' => $data['cr'],
                    'ct' => $data['ct'],
                    'induksi' => $data['induksi'],
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]
            );            
            // $rosters = new Rosters;
            // // $rosters->unit_id = $id_unit->id;
            // $rosters->user_id = $id_user->id;
            // $rosters->date = $x['date'];
            // $rosters->shift = $data['shift'];
            // $rosters->off = $data['off'];
            // $rosters->cr = $data['cr'];
            // $rosters->ct = $data['ct'];
            // $rosters->induksi = $data['induksi'];
            // $rosters->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}

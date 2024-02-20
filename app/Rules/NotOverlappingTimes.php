<?php

namespace App\Rules;

use App\Models\RequestTimeoff;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotOverlappingTimes implements Rule
{
    protected $start_date;
    protected $end_date;
    protected $timeoff_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_date, $end_date, $timeoff_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->timeoff_id = $timeoff_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_id = Auth::user()->id;

        $timeoff_checks = RequestTimeoff::where('user_id', $user_id)->where(function ($query) {
            $query->where('approve', '1')
                ->orWhere('approve', '0');
        })->get();

        $newStartTime = Carbon::createFromFormat('Y-m-d H:i:s.v', $this->start_date)->startOfDay();
        $newEndTime = Carbon::createFromFormat('Y-m-d H:i:s.v', $this->end_date)->endOfDay();
        $newStart = $newStartTime->format('Y-m-d');
        $newEnd = $newEndTime->format('Y-m-d');

        foreach ($timeoff_checks as $time) {
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $time->start_date);
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $time->end_date);
            $startDate = $startTime->format('Y-m-d');
            $endDate = $endTime->format('Y-m-d');

            if (($newStart >= $startDate && $newStart <= $endDate) ||
                ($newEnd >= $startDate && $newEnd <= $endDate) ||
                ($newStart <= $startDate && $newEnd >= $endDate)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sudah ada pengajuan cuti di waktu ini';
    }
}

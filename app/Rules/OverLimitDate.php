<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use App\Models\KuotaTimeoff;
use App\Models\Timeoff;
use App\Models\RequestTimeoff;
use Illuminate\Support\Facades\Auth;


class OverLimitDate implements Rule
{
    protected $start_date;
    protected $end_date;
    protected $timeoff_id;
    // protected $user_id;
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
        $newStartTime = Carbon::parse($this->start_date);
        $newEndTime = Carbon::parse($this->end_date);
        $StartTime = Carbon::parse($newStartTime);
        $EndTime = Carbon::parse($newEndTime);
        $countDate = $StartTime->diffInDays($EndTime);
        $countDate = $countDate + 1;
        $kuota_timeoff = KuotaTimeoff::where('timeoff_id', $this->timeoff_id)->first();
        if ($kuota_timeoff->kuota === '-') {
            return true;
        } else {
            if ($countDate > $kuota_timeoff->kuota) {
                return false;
            } else {
                return true;
            }
        }
        // $user_id = Auth::user()->id;

        // $exist_timeoffs = RequestTimeoff::where('user_id', $user_id)
        //     ->where('timeoff_id', $timeoff_id)
        //     ->get();


        // $countSum = 0;

        // foreach ($exist_timeoffs as $exist_timeoff) {
        //     $newStartTime = Carbon::parse($exist_timeoff->start_date);
        //     $newEndTime = Carbon::parse($exist_timeoff->end_date);
        //     $countDate = $newStartTime->diffInDays($newEndTime);
        //     $countSum += $countDate;
        // }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Melebihi limit cuti terkait';
    }
}

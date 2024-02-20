<?php

namespace Modules\PinjamMobil\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Modules\PinjamMobil\Entities\BorrowVehicles;

class BorrowRule implements Rule
{
    protected $start_date;
    protected $end_date;
    protected $vehicles_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_date, $end_date, $vehicles_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->vehicles_id = $vehicles_id;
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
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        $borrowVehicles = BorrowVehicles::where('vehicles_id', $this->vehicles_id)
            ->whereIn('status', [2, 4])
            ->get();
        // dd($borrowVehicles);

        foreach ($borrowVehicles as $borrow) {

            $get_start_date = $borrow->start_date;
            $get_end_date = $borrow->end_date;

            if ($startDate >= $get_start_date && $startDate < $get_end_date) {
                return false;
            }
            if ($endDate > $get_start_date && $endDate <= $get_end_date) {
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
        return 'The Vehicle has been reserved';
    }
}

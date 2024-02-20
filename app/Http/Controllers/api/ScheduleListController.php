<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;

class ScheduleListController extends Controller
{
    public  function getshifttoday(User $user, $user_id, $tanggal)
    {
        return $user->getshifttoday($user_id, $tanggal);
        // $oVal = ShiftToday::getshifttoday($user_id, $tanggal);
        // return $oVal;
    }

    public function narik_libur(User $user, $month, $year_req)
    {
        $all_dates = $user->narik_libur($month, $year_req);
        // $all_dates = ShiftToday::narik_libur($month, $year_req);
        return ResponseFormatter::success($all_dates, 'Pull schedule success');
    }


    public function holiday_date(User $user, $year_req)
    {
        try {
            $user->apiWithoutKey($year_req);
            return ResponseFormatter::success([
                'Success' => "good job!",
            ], 'Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => (string)$error->getMessage(),
            ], 'Something went wrong', 500);
            //throw $th;
        }
    }
}

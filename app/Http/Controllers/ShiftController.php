<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ResponseFormatter;
use App\Models\RequestShift;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shiftController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'shift_id' => ['required'],
                'selected_date' => ['required'],
            ]);

           $data = RequestShift::create([
                'user_id' => Auth::user()->id,
                'shift_id' => $request->shift_id,
                'selected_date' => $request->selected_date,
                'description' => $request->description,
                'approve_by' => Auth::user()->approval_line_id
            ]);

            return ResponseFormatter::success([
                'data' => $data
            ],'Request Shift has sent');
            } catch (Exception $error) {
                return ResponseFormatter::error([
                    'error' => (string)$error->getMessage(),
                ],'Something went wrong', 500);
            }
    }



    public function view($id)
    {
        $data = RequestShift::where('id',$id)->with(['shift','user'])->get();
        return ResponseFormatter::success($data, 'Data profile user berhasil diambil');
    }


}

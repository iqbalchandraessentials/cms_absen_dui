<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OverLimitDate;
use App\Rules\NotOverlappingTimes;


class timeoffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => [
                'required',
                new OverLimitDate($this->start_date, $this->end_date, $this->timeoff_id),
                new NotOverlappingTimes($this->start_date, $this->end_date, $this->timeoff_id),
            ],
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $customMessage = $this->getCustomErrorMessage($validator->failed());
            $response = [
                'status' => 'error',
                'message' => $customMessage,
                'errors' => $validator->errors()
            ];

            throw new \Illuminate\Validation\ValidationException($validator, response()->json($response, 422));
        }
    }

    private function getCustomErrorMessage($failedRules)
    {
        // Check if the 'start_date' rule failed
        if (isset($failedRules['start_date'])) {
            $startDatesFailedRules = $failedRules['start_date'];

            // Loop through the failed 'start_date' rules
            foreach ($startDatesFailedRules as $rule => $parameters) {
                // Check the rule name and return the corresponding custom error message
                if ($rule === 'App\Rules\OverLimitDate') {
                    // Custom error message for 'OverLimitDate'
                    return 'Melebihi limit cuti terkait';
                } elseif ($rule === 'App\Rules\NotOverlappingTimes') {
                    // Custom error message for 'NotOverlappingTimes'
                    return 'Sudah ada pengajuan cuti di waktu ini';
                }
            }
        }

        return null; // Return null if no custom error message found
    }
}

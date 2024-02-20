<?php

namespace Modules\PinjamMobil\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\PinjamMobil\Rules\BorrowRule;

class BorrowRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                new BorrowRule($this->start_date, $this->end_date, $this->vehicles_id),
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

            throw new \Illuminate\Validation\ValidationException($validator, response()->json($response, 200));
        }
    }

    private function getCustomErrorMessage($failedRules)
    {
        // Check if the 'start_date' rule failed
        if (isset($failedRules['start_date'])) {
            $startDatesFailedRules = $failedRules['start_date'];

            // Loop through the failed 'start_date' rules
            foreach ($startDatesFailedRules as $rule => $parameters) {
                if ($rule === 'Modules\PinjamMobil\Rules\BorrowRule') {
                    // Custom error message for 'OverLimitDate'
                    return 'The Vehicle has been reserved';
                }
            }
        }

        return null; // Return null if no custom error message found
    }


}

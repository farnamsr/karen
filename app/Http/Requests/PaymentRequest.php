<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;



class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

     protected  function failedValidation(Validator $validator):void
     {
        // throw new HttpResponseException(response()->json([
        //     'status' => config("errors.INVALID_FORM"),
        //     'errors' => $validator->errors(),
        //     'result' => false
        // ]));
     }
    public function rules(Request $request): array
    {
        $request['amount'] = str_replace(",", "", en_number($request["amount"]));
        return [
            "amount" => ["required", "integer"]
        ];
    }

}

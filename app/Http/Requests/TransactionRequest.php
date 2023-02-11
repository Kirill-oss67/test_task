<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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

            "amount" => ['required', 'numeric'],
            "currency" => ['required', 'string'],
            "payment_system" => ['required', 'string'],
            "card_number" => ['required', 'digits:16'],
            "valid_until" => ['required', 'date'],
            "CVV/CVC" => ['required', 'digits:3'],
            "surname" => ['required', 'string'],
            "name" => ['required', 'string'],
            "phone_number" => ['required', 'integer'],
            "note" => ""

        ];
    }
}

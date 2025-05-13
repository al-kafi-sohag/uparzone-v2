<?php

namespace App\Http\Requests\User;

use App\Rules\User\WithdrawBalanceRule;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function prepareForValidation()
    {
        $this->merge([
            'amount' => str_replace(',', '', $this->amount),
        ]);
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:500', new WithdrawBalanceRule()],
            'gateway' => 'required|in:bKash,Nagad',
            'account_number' => 'required|numeric|digits:11',
            'division' => 'required|in:dhaka,chittagong,khulna,rajshahi,barisal,rangpur,mymensingh',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be at least 500',
            'gateway.required' => 'Gateway is required',
            'gateway.in' => 'Gateway must be bKash or Nagad',
            'account_number.required' => 'Account number is required',
            'account_number.numeric' => 'Account number must be a number',
            'account_number.digits' => 'Account number must be 11 digits',
            'division.required' => 'Division is required',
            'division.in' => 'Division must be dhaka, chittagong, khulna, rajshahi, barisal, rangpur, or mymensingh',
        ];
    }

    public function redirectTo()
    {
        return route('user.home');
    }


}

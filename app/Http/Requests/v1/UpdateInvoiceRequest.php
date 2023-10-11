<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if($method == 'PUT'){
            return [
                'customerID'=>['required','integer'],
                'amount'=>['required','numeric'],
                'status'=>['required',Rule::in(['B','P','V','b','p','v'])],
                'billedDate'=>['required','date_format:Y-m-d H:i:s'],
                'paidDate'=>['date_format:Y-m-d H:i:s','nullable'],            
            ];
        }else{
            return [
                'customerID'=>['sometimes','required','integer'],
                'amount'=>['sometimes','required','numeric'],
                'status'=>['sometimes','required',Rule::in(['B','P','V','b','p','v'])],
                'billedDate'=>['sometimes','required','date_format:Y-m-d H:i:s'],
                'paidDate'=>['sometimes','date_format:Y-m-d H:i:s','nullable'],            
            ];            
        }
    }

    protected function prepareForValidation()
    {
        if($this->customerID){
            $this->merge([
                'customer_id'=>$this->customerID]);
        }
        if($this->billedDate){
            $this->merge([
                'billed_date'=>$this->billedDate]);
        }     
        if($this->paidDate){
            $this->merge([
                'paid_date'=>$this->paidDate]);
        }              
    }
    
}

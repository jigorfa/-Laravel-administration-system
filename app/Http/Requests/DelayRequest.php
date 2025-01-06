<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelayRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_code' => 'required|exists:employee,code',
            
            'detail' => 'required|array|min:1',
            'detail.*.delay_date' => 'required|date',
            'detail.*.arrival' => 'required',
            'detail.*.leave' => 'required',
            'detail.*.description' => 'nullable|string|max:191',
        ];
    }
    
    public function messages()
    {
        return [
            'employee_code.required' => 'O código do funcionário é obrigatório.',
            'employee_code.exists' => 'O código do funcionário não foi encontrado.',

            'detail.*.delay_date.required' => 'A data do atraso é obrigatória.',
            'detail.*.arrival.required' => 'O horário de chegada é obrigatório.',
            'detail.*.leave.required' => 'O horário de saída é obrigatório.',
            'detail.*.description.max' => 'A descrição pode ter no máximo 191 caracteres.',
        ];
    }
}

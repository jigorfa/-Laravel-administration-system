<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpiRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_code' => 'required|exists:employee,code',
            
            'detail' => 'required|array|min:1',
            'detail.*.expedition_date' => 'required|date',
            'detail.*.name' => 'required',
            'detail.*.quantity' => 'required',
            'detail.*.description' => 'nullable|string|max:191',
        ];
    }
    
    public function messages()
    {
        return [
            'employee_code.required' => 'O código do funcionário é obrigatório.',
            'employee_code.exists' => 'O código do funcionário não foi encontrado.',

            'detail.*.expedition_date.required' => 'A data do atraso é obrigatória.',
            'detail.*.name.required' => 'O horário de chegada é obrigatório.',
            'detail.*.quantity.required' => 'O horário de saída é obrigatório.',
            'detail.*.description.max' => 'A descrição pode ter no máximo 191 caracteres.',
        ];
    }
}

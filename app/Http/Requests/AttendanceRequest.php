<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|integer',
            'name' => 'required|string|max:191',
            'adjuntancy' => 'required|string|max:191',
            'delay_date' => 'required|date',
            'arrival' => 'required',
            'leave' => 'required|after:arrival',
            'motive' => 'required|string|max:191',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'O campo código é obrigatório',
            'code.integer' => 'O código deve ser um número inteiro',

            'name.required' => 'O campo nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.max' => 'O nome não pode ter mais que 191 caracteres',

            'adjuntancy.required' => 'O campo cargo é obrigatório',
            'adjuntancy.string' => 'O cargo deve ser um texto válido',
            'adjuntancy.max' => 'O cargo não pode ter mais que 191 caracteres',

            'delay_date.required' => 'O campo data do atraso é obrigatório',
            'delay_date.date' => 'O campo data deve conter uma data válida',

            'arrival.required' => 'O campo horário de chegada é obrigatório',

            'leave.required' => 'O campo horário de saída é obrigatório',
            'leave.after' => 'O horário de saída deve ser após o horário de chegada',
            
            'motive.required' => 'O campo motivo do atraso é obrigatório',
            'motive.string' => 'O motivo deve ser um texto válido',
            'motive.max' => 'O motivo não pode ter mais que 191 caracteres',
        ];
    }
}

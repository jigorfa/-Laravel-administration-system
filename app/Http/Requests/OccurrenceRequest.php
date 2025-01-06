<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccurrenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajuste conforme necessário
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'employee_code' => 'required|exists:employee,code',
            'detail' => 'required|array|min:1',
            'detail.*.occasion_id' => 'required|exists:occasion,id',
            'detail.*.occurrence_date' => 'required|date',
            'detail.*.description' => 'nullable|string|max:191',
        ];
    }

    /**
     * Custom messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'employee_code.required' => 'O código de funcionário é obrigatório.',
            'employee_code.exists' => 'O código de funcionário selecionado é inválido.',
            'occasion_id.required' => 'O tipo de ocorrência é obrigatório.',
            'occasion_id.exists' => 'O tipo de ocorrência selecionado é inválido.',
            'occurrence_date.required' => 'A data da ocorrência é obrigatória.',
            'description.required' => 'A descrição da ocorrência é obrigatória.'
        ];
    }
}
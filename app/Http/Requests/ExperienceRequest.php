<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'adjuntancy' => 'required',
            'admission' => 'required',
            'contract1' => 'required',
            'contract2' => 'required',
            'salary' => 'required|max:10',
            'situation_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'code.required' => 'O campo código é obrigatório',
            'name.required' => 'O campo nominal é obrigatório',
            'adjuntancy.required' => 'O campo cargo é obrigatório',
            'admission.required' => 'O campo admissão é obrigatório',
            'contract1.required' => 'O campo 1º contrato é obrigatório',
            'contract2.required' => 'O campo 2º contrato é obrigatório',
            'salary' => 'O campo salarial é obrigatório',
            'salary.max' => 'O salário só pode ter no máximo 8 números',
            'situation_id.required' => 'O campo situacional é obrigatório',
        ];
    }
}

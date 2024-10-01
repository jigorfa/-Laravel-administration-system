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
            'code' => 'required|integer', // Código do funcionário
            'name' => 'required|string|max:191',
            'adjuntancy' => 'required|string|max:191', // Cargo
            'admission' => 'required|date', // Data de admissão
            'contract1' => 'required|date|after_or_equal:admission', // Data do 1º contrato
            'contract2' => 'required|date|after_or_equal:contract1', // Data do 2º contrato deve ser posterior ou igual à do 1º
            'salary' => 'required|max:99999999', // Salário com limite de 8 dígitos
            'situation_id' => 'required|exists:situation,id', // ID da situação deve existir na tabela 'situations'
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.integer' => 'O campo código deve ser um número inteiro.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string válida.',
            'name.max' => 'O nome deve ter no máximo 191 caracteres.',

            'adjuntancy.required' => 'O campo cargo é obrigatório.',
            'adjuntancy.string' => 'O cargo deve ser uma string válida.',
            'adjuntancy.max' => 'O cargo deve ter no máximo 191 caracteres.',

            'admission.required' => 'O campo de admissão é obrigatório.',
            'admission.date' => 'A data de admissão deve ser uma data válida.',

            'contract1.required' => 'O campo 1º contrato é obrigatório.',
            'contract1.date' => 'A data do 1º contrato deve ser uma data válida.',
            'contract1.after_or_equal' => 'A data do 1º contrato deve ser após ou igual à data de admissão.',

            'contract2.required' => 'O campo 2º contrato é obrigatório.',
            'contract2.date' => 'A data do 2º contrato deve ser uma data válida.',
            'contract2.after_or_equal' => 'A data do 2º contrato deve ser após ou igual à data do 1º contrato.',

            'salary.required' => 'O campo salário é obrigatório.',
            'salary.max' => 'O salário não pode exceder 8 dígitos.',

            'situation_id.required' => 'O campo situação é obrigatório.',
            'situation_id.exists' => 'A situação selecionada é inválida.',
        ];
    }
}

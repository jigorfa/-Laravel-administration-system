<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'code' => 'required|max:999',
            'ctps_code' => 'required|string|max:20',
            'pis_code' => 'required|string|max:20',
            'instruction_id' => 'required|exists:instruction,id',
            'personal_code' => 'required|string|max:191',
            'vote_code' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'telephone' => 'required|string|max:15',
            'name' => 'required|string|max:191',
            'adjuntancy' => 'required|string|max:191',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            'number' => 'required|max:999999999',
            'postal_code' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'admission' => 'required|date',
            'contract1' => 'required|date|after_or_equal:admission',
            'contract2' => 'required|date|after_or_equal:contract1',
            'salary' => 'required|max:99999999',
            'situation_id' => 'required|exists:situation,id',
            'enterprise_id' => 'required|exists:enterprise,id',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['demission'] = 'nullable|date|after_or_equal:admission';
        }
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.max' => 'O limite de caracteres foi ultrapassado.',

            'ctps_code.required' => 'O campo CTPS é obrigatório.',
            'ctps_code.max' => 'O campo CTPS deve ter no máximo 20 caracteres.',

            'pis_code.required' => 'O campo PIS é obrigatório.',
            'pis_code.max' => 'O campo PIS deve ter no máximo 20 caracteres.',

            'instruction_id.required' => 'O campo instrução é obrigatório.',
            'instruction_id.exists' => 'O campo instrução deve ser válido.',

            'personal_code.required' => 'O campo código pessoal é obrigatório.',

            'vote_code.required' => 'O campo título de eleitor é obrigatório.',
            'vote_code.max' => 'O campo título de eleitor excedeu o limite de caracteres.',

            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',

            'telephone.required' => 'O campo telefone é obrigatório.',
            'telephone.string' => 'O telefone deve conter somente texto.',
            'telephone.max' => 'O telefone deve ter no máximo 15 caracteres.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve conter somente texto.',
            'name.max' => 'O nome deve ter no máximo 191 caracteres.',

            'adjuntancy.required' => 'O campo cargo é obrigatório.',
            'adjuntancy.string' => 'O cargo deve conter somente texto.',
            'adjuntancy.max' => 'O cargo deve ter no máximo 191 caracteres.',

            'state.required' => 'O campo estado é obrigatório.',
            'state.string' => 'O estado deve conter somente texto.',
            'state.max' => 'O estado deve ter no máximo 100 caracteres.',

            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'A cidade deve conter somente texto.',
            'city.max' => 'A cidade deve ter no máximo 100 caracteres.',

            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'neighborhood.string' => 'O bairro deve conter somente texto.',
            'neighborhood.max' => 'O bairro deve ter no máximo 100 caracteres.',

            'number.required' => 'O campo número é obrigatório.',
            'number.max' => 'O limite de caracteres foi ultrapassado.',

            'postal_code.required' => 'O campo código postal é obrigatório.',
            'postal_code.string' => 'O código postal deve conter somente texto.',
            'postal_code.max' => 'O código postal deve ter no máximo 15 caracteres.',

            'street.required' => 'O campo rua é obrigatório.',
            'street.string' => 'A rua deve conter somente texto.',
            'street.max' => 'A rua deve ter no máximo 255 caracteres.',

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
            'situation_id.exists' => 'O campo situação deve ser válido.',

            'enterprise_id.required' => 'O campo empresa é obrigatório.',
            'enterprise_id.exists' => 'O campo empresa deve ser válido.',

            'demission.date' => 'A data de demissão deve ser uma data válida.',
            'demission.after_or_equal' => 'A data de demissão deve ser posterior ou igual à data de admissão.',
        ];
    }
}

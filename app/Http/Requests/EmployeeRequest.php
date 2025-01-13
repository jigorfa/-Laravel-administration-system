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
            'name' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'nationality' => 'required|string|max:100',
            'naturalness' => 'required|string|max:100',
            'color_id' => 'required|exists:color,id',
            'gender_id' => 'required|exists:gender,id',
            'cpf_code' => 'required|string|max:20',
            'ctps_code' => 'required|string|max:20',
            'pis_code' => 'required|string|max:20',
            'vote_code' => 'required|string|max:20',
            'cnh_code' => 'nullable|string|max:20',
            'telephone' => 'required|string|max:15',
            'instruction_id' => 'required|exists:instruction,id',
            'civil_state_id' => 'required|exists:civil_state,id',
            'postal_code' => 'required|string|max:15',
            'address' => 'required|string|max:150',
            'enterprise_id' => 'required|exists:enterprise,id',
            'situation_id' => 'required|exists:situation,id',
            'code' => 'required|max:20',
            'adjuntancy' => 'required|string|max:100',
            'admission' => 'required|date',
            'contract1' => 'required|date|after_or_equal:admission',
            'contract2' => 'required|date|after_or_equal:contract1',
            'salary' => 'required|max:100'
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

            'cpf_code.required' => 'O campo CPF é obrigatório.',

            'vote_code.required' => 'O campo título de eleitor é obrigatório.',
            'vote_code.max' => 'O campo título de eleitor excedeu o limite de caracteres.',

            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',

            'telephone.required' => 'O campo telefone é obrigatório.',
            'telephone.string' => 'O campo telefone deve conter somente texto.',
            'telephone.max' => 'O telefone deve ter no máximo 15 caracteres.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve conter somente texto.',
            'name.max' => 'O nome deve ter no máximo 100 caracteres.',

            'adjuntancy.required' => 'O campo cargo é obrigatório.',
            'adjuntancy.string' => 'O campo cargo deve conter somente texto.',
            'adjuntancy.max' => 'O cargo deve ter no máximo 100 caracteres.',

            'postal_code.required' => 'O campo código postal é obrigatório.',
            'postal_code.string' => 'O campo código postal deve conter somente texto.',
            'postal_code.max' => 'O código postal deve ter no máximo 15 caracteres.',

            'address.required' => 'O campo endereço é obrigatório.',
            'address.string' => 'O campo endereço deve conter somente texto.',
            'address.max' => 'O campo endereço deve ter no máximo 255 caracteres.',

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

            'civil_state_id.required' => 'O campo estado civil é obrigatório.',
            'civil_state_id.exists' => 'O campo estado civil deve ser válido.',

            'gender_id.required' => 'O campo  de sexo é obrigatório.',
            'gender_id.exists' => 'O campo de sexo deve ser válido.',

            'demission.date' => 'A data de demissão deve ser uma data válida.',
            'demission.after_or_equal' => 'A data de demissão deve ser posterior ou igual à data de admissão.',

            'nationality.required' => 'O campo nacionalidade é obrigatório.',
            'nationality.string' => 'O campo de nacionalidade deve conter somente texto.',
            'nationality.max' => 'O campo de nacionalidade deve ter no máximo 100 caracteres.',

            'naturalness.required' => 'O campo naturalidade é obrigatório.',
            'naturalness.string' => 'O campo de naturalidade deve conter somente texto.',
            'naturalness.max' => 'O campo de naturalidade deve ter no máximo 100 caracteres.',

            'cnh_code.required' => 'O campo carteira de habilitação é obrigatório',
            'cnh_code.max' => 'O campo carteira de habilitação deve ter no máximo 20 caracteres'
        ];
    }
}

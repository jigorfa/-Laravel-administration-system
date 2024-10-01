<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttestRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'cause' => 'required|string|max:191',
            'annex' => 'nullable|file|mimes:pdf|max:2048', // Regra para aceitar apenas arquivos PDF com tamanho máximo de 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.integer' => 'O campo código deve ser um número inteiro.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome deve ter no máximo 191 caracteres.',

            'adjuntancy.required' => 'O campo cargo é obrigatório.',
            'adjuntancy.max' => 'O cargo deve ter no máximo 191 caracteres.',

            'start_date.required' => 'O campo de data inicial é obrigatório.',
            'start_date.date' => 'A data inicial deve ser uma data válida.',

            'end_date.required' => 'O campo de data final é obrigatório.',
            'end_date.date' => 'A data final deve ser uma data válida.',
            'end_date.after' => 'A data final deve ser posterior à data de início.',

            'cause.required' => 'O campo de causa social do atestado é obrigatório.',
            'cause.max' => 'O campo de causa deve ter no máximo 191 caracteres.',
            
            'annex.file' => 'O anexo deve ser um arquivo válido.',
            'annex.mimes' => 'O anexo deve ser um arquivo do tipo PDF.',
            'annex.max' => 'O anexo deve ter no máximo 2MB.',
        ];
    }
}

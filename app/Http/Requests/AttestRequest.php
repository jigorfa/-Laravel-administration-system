<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttestRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_code' => 'required|exists:employee,code',
            
            'detail' => 'required|array|min:1',
            'detail.*.start_attest' => 'required|date',
            'detail.*.end_attest' => 'required|date|after_or_equal:detail.*.start_attest',
            'detail.*.cause' => 'required|string|max:191',
            'detail.*.annex' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ];
    }
    
    public function messages()
    {
        return [
            'employee_code.required' => 'O código do funcionário é obrigatório.',
            'employee_code.exists' => 'O código do funcionário não foi encontrado.',

            'detail.required' => 'É necessário fornecer pelo menos um detalhe de atestado.',
            'detail.array' => 'Os detalhes do atestado devem ser um array.',
            
            'detail.*.start_attest.required' => 'A data de início do atestado é obrigatória.',
            'detail.*.start_attest.date' => 'A data de início do atestado deve ser uma data válida.',

            'detail.*.end_attest.required' => 'A data de término do atestado é obrigatória.',
            'detail.*.end_attest.date' => 'A data de término do atestado deve ser uma data válida.',
            'detail.*.end_attest.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',

            'detail.*.cause.required' => 'A causa do atestado é obrigatória.',
            'detail.*.cause.string' => 'A causa do atestado deve ser um texto válido.',
            'detail.*.cause.max' => 'A causa do atestado pode ter no máximo 191 caracteres.',

            'detail.*.annex.file' => 'O anexo deve ser um arquivo válido.',
            'detail.*.annex.mimes' => 'O anexo deve ser um arquivo no formato: pdf, jpg ou png.',
            'detail.*.annex.max' => 'O anexo pode ter no máximo 2 MB.',
        ];
    }
}

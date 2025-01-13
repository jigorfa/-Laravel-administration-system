<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Gender;
use App\Models\Instruction;
use App\Models\CivilState;
use App\Models\Enterprise;
use App\Models\Situation;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $countEmployee = Employee::count();

        $search = Employee::with('enterprise');

        if ($request->filled('search_code')) {
            $search->where('code', 'like', '%' . $request->search_code . '%');
        }

        if ($request->filled('search_name')) {
            $search->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->filled('search_adjuntancy')) {
            $search->where('adjuntancy', 'like', '%' . $request->search_adjuntancy . '%');
        }

        if ($request->filled('search_enterprise')) {
            $search->where('enterprise_id', $request->search_enterprise);
        }

        $search = $search->orderBy('code', 'ASC')->paginate(10)->withQueryString();

        $enterprises = Enterprise::all();

        return view('employee.index', [
            'employee' => $search,
            'countEmployee' => $countEmployee,
            'enterprises' => $enterprises,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $color = Color::orderBy('name', 'asc')->get();
        $gender = Gender::orderBy('name', 'asc')->get();
        $instruction = Instruction::orderBy('id', 'asc')->get();
        $civilState = CivilState::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('name', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();

        return view('employee.create', [
            'color' => $color,
            'gender' => $gender,
            'instruction' => $instruction,
            'civilState' => $civilState,
            'enterprise' => $enterprise,
            'situation' => $situation,          
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $request->validated();

        try {
            $employee = Employee::create([
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'nationality' => $request->nationality,
                'naturalness' => $request->naturalness,
                'color_id' => $request->color_id,
                'gender_id' => $request->gender_id,
                'cpf_code' => $request->cpf_code,
                'ctps_code' => $request->ctps_code,
                'pis_code' => $request->pis_code,
                'vote_code' => $request->vote_code,
                'cnh_code' => $request->filled('cnh_code') ? $request->cnh_code : null,
                'telephone' => $request->telephone,
                'instruction_id' => $request->instruction_id,
                'civil_state_id' => $request->civil_state_id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'enterprise_id' => $request->enterprise_id,
                'situation_id' => $request->situation_id,
                'code' => $request->code,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'demission' => null,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
            ]);

            return redirect()->route('employee.index')->with('success', 'Registro de funcionário cadastrado com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Erro de duplicação: já existe um funcionário com este código.');
            }

            Log::warning('Erro no banco de dados ao cadastrar funcionário.', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro no banco de dados. Verifique os campos e tente novamente.');
        } catch (\Exception $e) {
  
            Log::error('Erro inesperado ao cadastrar funcionário.', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro inesperado. Por favor, tente novamente.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $color = Color::orderBy('name', 'asc')->get();
        $gender = Gender::orderBy('name', 'asc')->get();
        $instruction = Instruction::orderBy('id', 'asc')->get();
        $civilState = CivilState::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('name', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($code);

        return view('employee.show', [
            'color' => $color,
            'gender' => $gender,
            'instruction' => $instruction,
            'civilState' => $civilState,
            'enterprise' => $enterprise,
            'situation' => $situation, 
            'employee' => $employee,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    { 
        $color = Color::orderBy('name', 'asc')->get();
        $gender = Gender::orderBy('name', 'asc')->get();
        $instruction = Instruction::orderBy('id', 'asc')->get();
        $civilState = CivilState::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('name', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($code);
       

        return view('employee.edit', [
            'color' => $color,
            'gender' => $gender,
            'instruction' => $instruction,
            'civilState' => $civilState,
            'enterprise' => $enterprise,
            'situation' => $situation, 
            'employee' => $employee,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $code)
    {
        $request->validated();
        $employee = Employee::findOrFail($code);

        try {
            $employee->update([
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'nationality' =>$request->nationality,
                'naturalness' =>$request->naturalness,
                'color_id' => $request->color_id,
                'gender_id' => $request->gender_id,
                'cpf_code' => $request->cpf_code,
                'ctps_code' => $request->ctps_code,
                'pis_code' => $request->pis_code,
                'vote_code' => $request->vote_code,
                'cnh_code' => $request->cnh_code,
                'telephone' => $request->telephone,
                'instruction_id' => $request->instruction_id,
                'civil_state_id' => $request->civil_state_id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'enterprise_id' => $request->enterprise_id,
                'situation_id' => $request->situation_id,
                'code' => $request->code,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'demission' => $request->filled('demission') ? $request->demission : null,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
            ]);

            Log::info('Cadastro editado com sucesso', ['code' => $employee->code]);
            return redirect()->route('employee.index')->with('warning', 'Registro de funcionário editado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Cadastro não editado', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Cadastro não editado!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $employee = Employee::where('code', $code)->firstOrFail();
        $employee->delete();

        return redirect()->route('employee.index')->with('danger', 'Registro de funcionário deletado com sucesso!');
    }
    /**
     * Generate a PDF with the specificied resource
     */
    public function pdf($code)
    {
        $employee = Employee::findOrFail($code);

        $pdf = PDF::loadView('pdf.employee', ['employee' => $employee])
            ->setPaper('a4', 'portrait');

        return $pdf->download('funcionarios_' . $employee->code . '.pdf');
    }
}

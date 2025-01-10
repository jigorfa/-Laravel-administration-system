<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Situation;
use App\Models\Instruction;
use App\Models\Enterprise;
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
        $instruction = Instruction::orderBy('id', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('id', 'asc')->get();

        return view('employee.create', [
            'situation' => $situation,
            'instruction' => $instruction,
            'enterprise' => $enterprise,
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
                'code' => $request->code,
                'ctps_code' => $request->ctps_code,
                'pis_code' => $request->pis_code,
                'personal_code' => $request->personal_code,
                'vote_code' => $request->vote_code,
                'birth_date' => $request->birth_date,
                'telephone' => $request->telephone,
                'state' => $request->state,
                'city' => $request->city,
                'neighborhood' => $request->neighborhood,
                'number' => $request->number,
                'postal_code' => $request->postal_code,
                'street' => $request->street,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
                'instruction_id' => $request->instruction_id,
                'situation_id' => $request->situation_id,
                'enterprise_id' => $request->enterprise_id,
                'demission' => null,
            ]);

            return redirect()->route('employee.index')->with('success', 'Registro de funcionário cadastrado com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // Código de erro para duplicação
                return redirect()->back()->withInput()->with('error', 'Erro de duplicação: já existe um funcionário com este código.');
            }

            Log::warning('Erro no banco de dados ao cadastrar funcionário.', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro no banco de dados. Verifique os campos e tente novamente.');
        } catch (\Exception $e) {
            // Log para erros gerais
            Log::error('Erro inesperado ao cadastrar funcionário.', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Erro inesperado. Por favor, tente novamente.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $instruction = Instruction::orderBy('name', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($code);

        return view('employee.show', [
            'employee' => $employee,
            'instruction' => $instruction,
            'situation' => $situation,
            'enterprise' => $enterprise
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    { 
        $instruction = Instruction::orderBy('name', 'asc')->get();
        $situation = Situation::orderBy('name', 'asc')->get();
        $enterprise = Enterprise::orderBy('name', 'asc')->get();
        $employee = Employee::findOrFail($code);
       

        return view('employee.edit', [
            'employee' => $employee,
            'instruction' => $instruction,
            'situation' => $situation,
            'enterprise' => $enterprise,
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
                'code' => $request->code,
                'ctps_code' => $request->ctps_code,
                'pis_code' => $request->pis_code,
                'personal_code' => $request->personal_code,
                'vote_code' => $request->vote_code,
                'birth_date' => $request->birth_date,
                'telephone' =>  $request->telephone,
                'state' => $request->state,
                'city' => $request->city,
                'neighborhood' => $request->neighborhood,
                'number' => $request->number,
                'postal_code' => $request->postal_code,
                'street' => $request->street,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
                'instruction_id' => $request->instruction_id,
                'situation_id' => $request->situation_id,
                'enterprise_id' => $request->enterprise_id,
                'demission' => $request->filled('demission') ? $request->demission : null
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

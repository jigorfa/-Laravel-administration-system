<?php 

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\Attest;
use App\Models\AttestDetail;
use Illuminate\Http\Request;
use App\Http\Requests\AttestRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class AttestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Attest::with(['employee'])->withCount('detail');

        // Filtros de pesquisa
        if ($request->filled('search_code')) {
            $query->where('employee_code', 'like', '%' . $request->employee_code . '%');
        }

        if ($request->filled('search_name')) {
            $query->whereHas('employee', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        if ($request->filled('search_adjuntancy')) {
            $query->whereHas('employee', function ($query) use ($request) {
                $query->where('adjuntancy', 'like', '%' . $request->employee_adjuntancy . '%');
            });
        }

        if ($request->filled('search_enterprise')) {
            $query->whereHas('employee.enterprise', function ($query) use ($request) {
                $query->where('id', $request->search_enterprise);
            });
        }

        $search = $query->orderBy('employee_code', 'ASC')->paginate(10)->withQueryString();

        // Obter todas as empresas para o filtro
        $enterprises = Enterprise::all();

        return view('sst.attest.index', [
            'search' => $search,
            'enterprises' => $enterprises,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee = Employee::orderBy('code', 'asc')->get();

        return view('sst.attest.create', [
            'employee' => $employee,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AttestRequest $request)
    {
        try {
            $attest = Attest::create([
                'employee_code' => $request['employee_code'],
            ]);

            foreach ($request['detail'] as $details) {
                $annexPath = null;

                if (isset($details['annex']) && $details['annex'] instanceof \Illuminate\Http\UploadedFile) {
                    $annexPath = $details['annex']->store('attest_annexes', 'public');
                }

                $attest->detail()->create([
                    'start_attest' => $details['start_attest'],
                    'end_attest' => $details['end_attest'],
                    'cause' => $details['cause'],
                    'annex' => $annexPath,
                ]);
            }

            return redirect()->route('sst.attest.index')->with('success', 'Atestado criado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors('Erro ao salvar o atestado: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $attest = Attest::with('detail')->find($id);
        $employee = Employee::orderBy('name', 'asc')->get();

        return view('sst.attest.show', [
            'employee' => $employee,
            'attest' => $attest
        ]);
    }
    /** 
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $attest = Attest::with('detail')->find($id);
        
        if (!$attest) {
            return redirect()->route('sst.attest.index')->with('error', 'Atestado não encontrado.');
        }
    
        return view('sst.attest.edit', compact('attest')); // Passa a variável attest para a view
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(AttestRequest $request, $id)
    {
        try {
            $attest = Attest::with('detail')->findOrFail($id);
            
            $attest->update([
                'employee_code' => $request['employee_code'],
            ]);
    
            // Atualize ou crie os detalhes do atestado
            foreach ($request['detail'] as $detail) {
                // Se o ID do detalhe existe, é uma atualização, caso contrário, uma criação
                if (isset($detail['id']) && $detail['id']) {
                    // Encontre o detalhe correspondente e atualize
                    $attestDetail = AttestDetail::find($detail['id']);
                    $attestDetail->update([
                        'start_attest' => $detail['start_attest'],
                        'end_attest' => $detail['end_attest'],
                        'cause' => $detail['cause'],
                        'annex' => isset($detail['annex']) && $detail['annex'] instanceof \Illuminate\Http\UploadedFile
                            ? $detail['annex']->store('attest_annexes', 'public')
                            : $attestDetail->annex,  // Mantém o anexo atual se nenhum novo for enviado
                    ]);
                } else {
                    // Se o ID não existe, cria um novo detalhe de atestado
                    $annexPath = isset($detail['annex']) && $detail['annex'] instanceof \Illuminate\Http\UploadedFile
                        ? $detail['annex']->store('attest_annexes', 'public')
                        : null;
    
                    $attest->detail()->create([
                        'start_attest' => $detail['start_attest'],
                        'end_attest' => $detail['end_attest'],
                        'cause' => $detail['cause'],
                        'annex' => $annexPath,
                    ]);
                }
            }
    
            return redirect()->route('sst.attest.index')->with('success', 'Atestado atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors('Erro ao atualizar o atestado: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteDetail($id)
    {
        try {
            $detail = AttestDetail::find($id);
    
            if (!$detail) {
                return back()->with('error', 'Detalhe não encontrado.');
            }
    
            $attestId = $detail->attest_id;
    
            $detail->delete();
    
            return redirect()->route('sst.attest.edit', $attestId)->with('danger', 'Detalhe excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir o detalhe do atestado', ['error' => $e->getMessage()]);
            
            return back()->with('error', 'Erro ao excluir o detalhe: ' . $e->getMessage());
        }
    }
    /**
     * Remove all resources from storage.
     */
    public function destroy($id)
    {
        $attest = Attest::with('detail')->where('id', $id)->firstOrFail();

        try {
            $attest->detail()->delete(); // Excluir os detalhes associados
            $attest->delete(); // Excluir o registro principal

            return redirect()->route('sst.index')->with('danger', 'Registro de atestado deletado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Erro ao deletar atestado', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao deletar atestado: ' . $e->getMessage());
        }
    }
    /**
     * Fetch employee by code.
     */
    public function getEmployeeByCode($code)
    {
        $employee = Employee::where('code', $code)->first();

        if ($employee) {
            return response()->json([
                'name' => $employee->name,
                'adjuntancy' => $employee->adjuntancy,
            ]);
        }

        return response()->json(null);
    }
    /**
     * Generate a PDF with the specificied resources.
     */
    public function pdf($id)
    {
        $attest = Attest::with(['employee', 'detail'])
        ->findOrFail($id);

        $pdf = PDF::loadView('pdf.attest', ['attest' => $attest])
            ->setPaper('a4', 'portrait');

        return $pdf->download('atestados_' . $attest->employee->code . '.pdf');
    }
}
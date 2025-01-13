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
    
        return view('sst.attest.edit', compact('attest'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attest = Attest::findOrFail($id);
    
        if ($request->has('delete_existing')) {
            foreach ($request->delete_existing as $detailId) {
                $detail = AttestDetail::find($detailId);
                if ($detail) {
                    $detail->delete();
                }
            }
        }
    
        if ($request->has('detail')) {
            foreach ($request->detail as $key => $detailData) {
                if (strpos($key, 'new-') === 0) {
                    // Novo registro
                    $annexPath = null;
    
                    // Verificar se anexou um arquivo
                    if (isset($detailData['annex']) && $detailData['annex'] instanceof \Illuminate\Http\UploadedFile) {
                        $annexPath = $detailData['annex']->store('attest_annexes', 'public');
                    }
    
                    AttestDetail::create([
                        'attest_id' => $attest->id,
                        'start_attest' => $detailData['start_attest'],
                        'end_attest' => $detailData['end_attest'],
                        'cause' => $detailData['cause'],
                        'annex' => $annexPath,
                    ]);
                } else {
                    // Atualizar registro existente
                    $detail = AttestDetail::find($key);
                    if ($detail) {
                        // Verificar se o campo 'annex' existe em 'detailData' antes de acessá-lo
                        $annexPath = $detail->annex; // Se não for um arquivo novo, mantém o valor original
    
                        if (isset($detailData['annex']) && $detailData['annex'] instanceof \Illuminate\Http\UploadedFile) {
                            // Se anexou um arquivo novo, faz o upload
                            $annexPath = $detailData['annex']->store('attest_annexes', 'public');
                        }
    
                        $detail->update([
                            'start_attest' => $detailData['start_attest'],
                            'end_attest' => $detailData['end_attest'],
                            'cause' => $detailData['cause'],
                            'annex' => $annexPath,
                        ]);
                    }
                }
            }
        }
    
        return redirect()->route('sst.attest.index')->with('warning', 'Registro de atestado editado com sucesso!');
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

            return redirect()->route('sst.attest.index')->with('danger', 'Registro de atestado deletado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Erro ao deletar atestado', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao deletar atraso: ' . $e->getMessage());
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
<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\Occurrence;
use App\Models\OccurrenceDetail;
use App\Models\Occasion;
use Illuminate\Http\Request;
use App\Http\Requests\OccurrenceRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OccurrenceController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Occurrence::with(['employee'])->withCount('detail');

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

        return view('binder.occurrence.index', [
            'search' => $search,
            'enterprises' => $enterprises,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $occasion = Occasion::orderBy('name', 'asc')->get();
        $employee = Employee::orderBy('code', 'asc')->get();

        return view('binder.occurrence.create', [
            'occasion' => $occasion,
            'employee' => $employee,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(OccurrenceRequest $request)
    {
        try {
            $occurrence = Occurrence::create([
                'employee_code' => $request['employee_code'],
            ]);

            foreach ($request['detail'] as $details) {
                $annexPath = null;

                if (isset($details['annex']) && $details['annex'] instanceof \Illuminate\Http\UploadedFile) {
                    $annexPath = $details['annex']->store('occurrence_annexes', 'public');
                }

                $occurrence->detail()->create([
                    'occurrence_date' => $details['occurrence_date'],
                    'occasion_id' => $details['occasion_id'],
                    'description' => $details['description'],
                    'annex' => $annexPath,
                ]);
            }

            return redirect()->route('binder.occurrence.index')->with('success', 'Ocorrência criada com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors('Erro ao salvar a ocorrência: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $occurrence = Occurrence::with('detail')->findOrFail($id);
        $occasion = Occasion::orderBy('name', 'asc')->get();
        $employee = Employee::orderBy('name', 'asc')->get();

        return view('binder.occurrence.show', [
            'occurrence' => $occurrence,
            'employee' => $employee,
            'occasion' => $occasion,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $occurrence = Occurrence::with('detail')->findOrFail($id);
        $occasion = Occasion::orderBy('name', 'asc')->get();

        return view('binder.occurrence.edit', compact('occurrence', 'occasion'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(OccurrenceRequest $request, $id)
    {
        try {
            $occurrence = Occurrence::with('detail')->findOrFail($id);
            
            $occurrence->update([
                'employee_code' => $request['employee_code'],
            ]);
    
            // Atualize ou crie os detalhes do atestado
            foreach ($request['detail'] as $detail) {
                // Se o ID do detalhe existe, é uma atualização, caso contrário, uma criação
                if (isset($detail['id']) && $detail['id']) {
                    // Encontre o detalhe correspondente e atualize
                    $occurrenceDetail = OccurrenceDetail::find($detail['id']);
                    $occurrenceDetail->update([
                        'occurrence_date' => $detail['occurrence_date'],
                        'description' => $detail['description'],
                        'occasion_id' => $detail['occasion_id'],
                        'annex' => isset($detail['annex']) && $detail['annex'] instanceof \Illuminate\Http\UploadedFile
                            ? $detail['annex']->store('occurrence_annexes', 'public')
                            : $occurrenceDetail->annex,  // Mantém o anexo atual se nenhum novo for enviado
                    ]);
                } else {
                    // Se o ID não existe, cria um novo detalhe de atestado
                    $annexPath = isset($detail['annex']) && $detail['annex'] instanceof \Illuminate\Http\UploadedFile
                        ? $detail['annex']->store('occurrence_annexes', 'public')
                        : null;
    
                    $occurrence->detail()->create([
                        'occurrence_date' => $detail['occurrence_date'],
                        'description' => $detail['description'],
                        'occasion_id' => $detail['occasion_id'],
                        'annex' => $annexPath,
                    ]);
                }
            }

            return redirect()->route('binder.occurrence.index')->with('success', 'Registro de atraso atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar atraso', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao atualizar atraso: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteDetail($id)
    {
        try {
            $detail = OccurrenceDetail::find($id);
    
            if (!$detail) {
                return back()->with('error', 'Detalhe não encontrado.');
            }
    
            $occurrenceId = $detail->occurrence_id;
    
            $detail->delete();
    
            return redirect()->route('binder.occurrence.edit', $occurrenceId)->with('danger', 'Detalhe excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir o registro detalhado da ficha', ['error' => $e->getMessage()]);
            
            return back()->with('error', 'Erro ao excluir o detalhe: ' . $e->getMessage());
        }
    }
    /**
     * Remove all resources from storage.
     */
    public function destroy($id)
    {
        $occurrence = Occurrence::with('detail')->findOrFail($id);

        try {
            $occurrence->detail()->delete();
            $occurrence->delete();

            return redirect()->route('binder.occurrence.index')->with('danger', 'Registro de atraso deletado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Erro ao deletar atraso', ['error' => $e->getMessage()]);
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
        $occurrence = Occurrence::with(['employee', 'detail'])
        ->findOrFail($id);

        $occasion = Occasion::orderBy('name', 'asc')->get();

        $pdf = PDF::loadView('pdf.occurrence', ['occurrence' => $occurrence, 'occasion' => $occasion])
            ->setPaper('a4', 'portrait');

        return $pdf->download('ocorrencias_' . $occurrence->employee->code . '.pdf');
    }
}
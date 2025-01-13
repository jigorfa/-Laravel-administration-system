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
    public function update(Request $request, $id)
    {
        $occurrence = Occurrence::findOrFail($id);

        if ($request->has('delete_existing')) {
            foreach ($request->delete_existing as $detailId) {
                $detail = OccurrenceDetail::find($detailId);
                if ($detail) {
                    $detail->delete();
                }
            }
        }

        if ($request->has('detail')) {
            foreach ($request->detail as $key => $detailData) {
                if (strpos($key, 'new-') === 0) {
                    // Novo registro
                    $annexPath = $detailData['annex'] ?? null;

                    // Verificar se anexou um arquivo
                    if (isset($detailData['annex']) && $detailData['annex'] instanceof \Illuminate\Http\UploadedFile) {
                        $annexPath = $detailData['annex']->store('occurrence_annexes', 'public');
                    }

                    OccurrenceDetail::create([
                        'occurrence_id' => $occurrence->id,
                        'occurrence_date' => $detailData['occurrence_date'],
                        'occasion_id' => $detailData['occasion_id'],
                        'description' => $detailData['description'],
                        'annex' => $annexPath,
                    ]);
                } else {
                    // Atualizar registro existente
                    $detail = OccurrenceDetail::find($key);
                    if ($detail) {
                        // Verificar se o campo 'annex' existe em 'detailData' antes de acessá-lo
                        $annexPath = $detail->annex; // Se não for um arquivo novo, mantém o valor original

                        // Verificar se anexou um arquivo novo
                        if (isset($detailData['annex']) && $detailData['annex'] instanceof \Illuminate\Http\UploadedFile) {
                            // Se anexou um arquivo novo, faz o upload
                            $annexPath = $detailData['annex']->store('occurrence_annexes', 'public');
                        }

                        $detail->update([
                            'occurrence_date' => $detailData['occurrence_date'],
                            'occasion_id' => $detailData['occasion_id'],
                            'description' => $detailData['description'],
                            'annex' => $annexPath,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('binder.occurrence.index')->with('warning', 'Registro de ocorrência editado com sucesso!');
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

            return redirect()->route('binder.occurrence.index')->with('danger', 'Registro de ocorrência deletado com sucesso!');
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
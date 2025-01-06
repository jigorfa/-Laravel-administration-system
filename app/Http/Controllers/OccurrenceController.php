<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
        $occasion = Occasion::orderBy('name', 'asc')->get();

        $search = Occurrence::with(['employee']);

        if ($request->filled('employee_code')) {
            $search->where('employee_code', 'like', '%' . $request->employee_code . '%');
        }

        if ($request->filled('employee_name')) {
            $search->whereHas('employee', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        if ($request->filled('employee_adjuntancy')) {
            $search->whereHas('employee', function ($query) use ($request) {
                $query->where('adjuntancy', 'like', '%' . $request->employee_adjuntancy . '%');
            });
        }

        $search = $search->orderBy('employee_code', 'ASC')->paginate(10)->withQueryString();

        return view('binder.occurrence.index', [
            'search' => $search,
            'occasion' => $occasion,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $occasion = Occasion::orderBy('name', 'asc')->get();
        $employee = Employee::orderBy('name', 'asc')->get();

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
        $validated = $request->validated();

        if (!isset($validated['detail']) || empty($validated['detail'])) {
            return back()->withInput()->with('error', 'Nenhum detalhe de atraso foi fornecido.');
        }

        try {
            $occurrence = Occurrence::create([
                'employee_code' => $validated['employee_code'],
            ]);

            foreach ($validated['detail'] as $details) {
                $occurrence->detail()->create([
                    'occurrence_date' => $details['occurrence_date'],
                    'description' => $details['description'],
                    'occasion_id' => $details['occasion_id'],
                ]);
            }

            return redirect()->route('binder.occurrence.index')->with('success', 'Registro de atraso cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar atraso: ' . $e->getMessage());
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
        $occasion = Occasion::all();

        return view('binder.occurrence.edit', compact('occurrence', 'occasion'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(OccurrenceRequest $request, $id)
    {
        $occurrence = Occurrence::with('detail')->where('id', $id)->firstOrFail();
        $validated = $request->validated();

        try {
            $occurrence->update([
                'employee_code' => $validated['employee_code'],
            ]);

            $updatedIds = collect($validated['detail'])->pluck('id')->filter();

            $occurrence->detail()->whereNotIn('id', $updatedIds)->delete();

            foreach ($validated['detail'] as $details) {
                if (!empty($details['id'])) {
                    $existingDetail = $occurrence->detail()->find($details['id']);
                    if ($existingDetail) {
                        $existingDetail->update([
                            'occasion_id' => $details['occasion_id'],
                            'occurrence_date' => $details['occurrence_date'],
                            'description' => $details['description'],
                        ]);
                    }
                } else {
                    $occurrence->detail()->create([
                        'occasion_id' => $details['occasion_id'],
                        'occurrence_date' => $details['occurrence_date'],
                        'description' => $details['description'],
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
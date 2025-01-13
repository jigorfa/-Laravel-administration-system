<?php 

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\Epi;
use App\Models\EpiDetail;
use Illuminate\Http\Request;
use App\Http\Requests\EpiRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Epi::with(['employee'])->withCount('detail');

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

        return view('sst.epi.index', [
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

        return view('sst.epi.create', [
            'employee' => $employee,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(EpiRequest $request)
    {
        $validated = $request->validated();

        if (!isset($validated['detail']) || empty($validated['detail'])) {
            return back()->withInput()->with('error', 'Nenhum detalhe do documento EPI foi fornecido.');
        }

        try {
            $epi = Epi::create([
                'employee_code' => $validated['employee_code'],
            ]);

            foreach ($validated['detail'] as $details) {
                $epi->detail()->create([
                    'expedition_date' => $details['expedition_date'],
                    'name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'description' => $details['description'],
                ]);
            }

            return redirect()->route('sst.epi.index')->with('success', 'Registro do documento EPI cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar o documento EPI: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $epi = Epi::with('detail')->find($id);
        $employee = Employee::orderBy('name', 'asc')->get();

        return view('sst.epi.show', [
            'employee' => $employee,
            'epi' => $epi
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $epi = Epi::with('detail')->find($id);
        
        if (!$epi) {
            return redirect()->route('sst.epi.index')->with('error', 'Documento EPI não encontrado.');
        }
    
        return view('sst.epi.edit', compact('epi')); // Passa a variável delay para a view
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EpiRequest $request, $id)
    {
        $epi = Epi::with('detail')->where('id', $id)->firstOrFail();
        $validated = $request->validated();

        try {
            $epi->update([
                'employee_code' => $validated['employee_code'],
            ]);

            $updatedIds = collect($validated['detail'])->pluck('id')->filter();

            $epi->detail()->whereNotIn('id', $updatedIds)->delete();

            foreach ($validated['detail'] as $details) {
                if (!empty($details['id'])) {
                    $existingDetail = $epi->detail()->find($details['id']);
                    if ($existingDetail) {
                        $existingDetail->update([
                            'expedition_date' => $details['expedition_date'] ?? null,
                            'name' => $details['name'] ?? null,
                            'quantity' => $details['quantity'] ?? null,
                            'description' => $details['description'] ?? null,
                        ]);
                    }
                } else {
                    $epi->detail()->create([
                        'expedition_date' => $details['expedition_date'] ?? null,
                        'name' => $details['name'] ?? null,
                        'quantity' => $details['quantity'] ?? null,
                        'description' => $details['description'] ?? null,
                    ]);
                }
            }

            return redirect()->route('sst.epi.index')->with('success', 'Registro do documento EPI atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o documento de EPI', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao atualizar o documento EPI: ' . $e->getMessage());
        }
    }
    /**
     * Remove specifield resources from storage.
     */
    public function deleteDetail($id)
    {
        try {
            $detail = EpiDetail::find($id);

            if (!$detail) {
                return back()->with('error', 'Detalhe não encontrado.');
            }

            $epiId = $detail->epi_id;

            $detail->delete();

            return redirect()->route('sst.epi.edit', $epiId)->with('danger', 'Detalhe excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir o detalhe do EPI', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao excluir o detalhe: ' . $e->getMessage());
        }
    }
    /**
     * Remove all resources from storage.
     */
    public function destroy($id)
    {
        $epi = Epi::with('detail')->where('id', $id)->firstOrFail();

        try {
            $epi->detail()->delete();
            $epi->delete();

            return redirect()->route('sst.epi.index')->with('danger', 'Registro do documento EPI deletado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Erro ao deletar o documento EPI', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao deletar o documento EPI: ' . $e->getMessage());
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
        $epi = Epi::with(['employee', 'detail'])
        ->findOrFail($id);

        $pdf = PDF::loadView('pdf.epi', ['epi' => $epi])
            ->setPaper('a4', 'portrait');

        return $pdf->download('epis_' . $epi->employee->code . '.pdf');
    }
}
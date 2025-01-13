<?php 

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\Delay;
use App\Models\DelayDetail;
use Illuminate\Http\Request;
use App\Http\Requests\DelayRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class DelayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Delay::with(['employee'])->withCount('detail');

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

        return view('binder.delay.index', [
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

        return view('binder.delay.create', [
            'employee' => $employee,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DelayRequest $request)
    {
        $validated = $request->validated();

        if (!isset($validated['detail']) || empty($validated['detail'])) {
            return back()->withInput()->with('error', 'Nenhum detalhe de atraso foi fornecido.');
        }

        try {
            $delay = Delay::create([
                'employee_code' => $validated['employee_code'],
            ]);

            foreach ($validated['detail'] as $details) {
                $delay->detail()->create([
                    'delay_date' => $details['delay_date'],
                    'arrival' => $details['arrival'],
                    'leave' => $details['leave'],
                    'description' => $details['description'],
                ]);
            }

            return redirect()->route('binder.delay.index')->with('success', 'Registro de atraso cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao cadastrar atraso: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $delay = Delay::with('detail')->find($id);
        $employee = Employee::orderBy('name', 'asc')->get();

        return view('binder.delay.show', [
            'employee' => $employee,
            'delay' => $delay
        ]);
    }
    /** 
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $delay = Delay::with('detail')->find($id);
        
        if (!$delay) {
            return redirect()->route('binder.delay.index')->with('error', 'Atraso não encontrado.');
        }
    
        return view('binder.delay.edit', compact('delay')); // Passa a variável delay para a view
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(DelayRequest $request, $id)
    {
        $delay = Delay::with('detail')->where('id', $id)->firstOrFail();
        $validated = $request->validated();

        try {
            $delay->update([
                'employee_code' => $validated['employee_code'],
            ]);

            $updatedIds = collect($validated['detail'])->pluck('id')->filter();

            $delay->detail()->whereNotIn('id', $updatedIds)->delete();

            foreach ($validated['detail'] as $details) {
                if (!empty($details['id'])) {
                    // Atualizar o registro existente
                    $existingDetail = $delay->detail()->find($details['id']);
                    if ($existingDetail) {
                        $existingDetail->update([
                            'delay_date' => $details['delay_date'] ?? null,
                            'arrival' => $details['arrival'] ?? null,
                            'leave' => $details['leave'] ?? null,
                            'description' => $details['description'] ?? null,
                        ]);
                    }
                } else {
                    $delay->detail()->create([
                        'delay_date' => $details['delay_date'] ?? null,
                        'arrival' => $details['arrival'] ?? null,
                        'leave' => $details['leave'] ?? null,
                        'description' => $details['description'] ?? null,
                    ]);
                }
            }

            return redirect()->route('binder.delay.index')->with('success', 'Registro de atraso atualizado com sucesso!');
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
            $detail = DelayDetail::find($id);

            if (!$detail) {
                return back()->with('error', 'Detalhe não encontrado.');
            }

            $delayId = $detail->delay_id;

            $detail->delete();

            return redirect()->route('binder.delay.edit', $delayId)->with('danger', 'Detalhe excluído com sucesso!');
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
        $delay = Delay::with('detail')->where('id', $id)->firstOrFail();

        try {
            $delay->detail()->delete(); // Excluir os detalhes associados
            $delay->delete(); // Excluir o registro principal

            return redirect()->route('binder.delay.index')->with('danger', 'Registro de atraso deletado com sucesso!');
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
        $delay = Delay::with(['employee', 'detail'])
        ->findOrFail($id);

        $pdf = PDF::loadView('pdf.delay', ['delay' => $delay])
            ->setPaper('a4', 'portrait');

        return $pdf->download('atrasos_' . $delay->employee->code . '.pdf');
    }

}
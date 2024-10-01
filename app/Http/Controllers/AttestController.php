<?php

namespace App\Http\Controllers;

use App\Models\Attest;
use Illuminate\Http\Request;
use App\Http\Requests\AttestRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AttestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicializa a consulta base
        $countAttest = attest::count();
        $search = attest::query();

        // Adiciona filtros se fornecidos
        if ($request->filled('code')) {
            $search->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('name')) {
            $search->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('adjuntancy')) {
            $search->where('adjuntancy', 'like', '%' . $request->adjuntancy . '%');
        }

        // Ordena e pagina os resultados
        $search = $search->orderBy('code', 'ASC')->paginate(10)->withQueryString();

        // Retorna a view com os dados
        return view('attest.index', [
            'attest' => $search,
            'count' => $countAttest
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttestRequest $request)
    {
        $request->validated();

        try {
            // Calcular o total de dias
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $total_days = $startDate->diffInDays($endDate) + 1; // Inclui o dia inicial e final

            // Preparar o nome do anexo se houver upload
            $annexName = null;
            if ($request->hasFile('annex') && $request->file('annex')->isValid()) {
                $annex = $request->file('annex');
                $annexName = md5($annex->getClientOriginalName() . strtotime("now")) . '.' . $annex->getClientOriginalExtension();
                $annex->move(public_path('img/attestsPdf'), $annexName); // Pasta para salvar o anexo
            }

            // Criar novo registro
            $attest = attest::create([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'cause' => $request->cause,
                'total_days' => $total_days,
                'annex' => $annexName, // Armazena o nome do arquivo do anexo
            ]);

            return redirect()->route('attest.index')->with('success', 'Registro cadastrado com sucesso!');
        } catch (\Exception $e) {
            Log::warning('Registro não cadastrado', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Registro não cadastrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $attest = attest::findOrFail($code);

        return view('attest.edit', [
            'attest' => $attest,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttestRequest $request, $code)
    {
        $request->validated();
        $attest = attest::findOrFail($code);

        try {
            // Calcular o total de dias
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $total_days = $startDate->diffInDays($endDate) + 1; // Inclui o dia inicial e final

            // Verifica se há upload de uma nova anexo
            $annexName = $attest->annex; // Manter a anexo atual se não for alterada

            if ($request->hasFile('annex') && $request->file('annex')->isValid()) {
                $annex = $request->file('annex');
                $annexName = md5($annex->getClientOriginalName() . strtotime("now")) . '.' . $annex->getClientOriginalExtension();

                // Verifica se o arquivo é PDF
                if ($annex->getClientOriginalExtension() === 'pdf') {
                    $annex->move(public_path('img/attestsPdf'), $annexName); // Pasta para salvar o arquivo PDF
                } else {
                    return back()->withInput()->with('error', 'Apenas arquivos PDF são permitidos.');
                }
            }

            // Atualizar registro
            $attest->update([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'cause' => $request->cause,
                'total_days' => $total_days,
                'annex' => $annexName, // Corrigido para $annexName
            ]);

            Log::info('Cadastro editado com sucesso', ['code' => $attest->code]);
            return redirect()->route('attest.index')->with('success', 'Registro editado com sucesso!');
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
        $attest = attest::findOrFail($code);

        // Deletar o anexo associado, se houver
        if ($attest->annex && file_exists(public_path('img/attestsPdf/' . $attest->annex))) {
            unlink(public_path('img/attestsPdf/' . $attest->annex));
        }

        $attest->delete();

        return redirect()->route('attest.index')->with('danger', 'Registro deletado com sucesso!');
    }

    /**
     * Generate a PDF with the attest records.
     */
    public function pdf(Request $request)
    {
        // Recuperar e filtrar os registros
        $search = attest::query();

        if ($request->filled('code')) {
            $search->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('name')) {
            $search->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('adjuntancy')) {
            $search->where('adjuntancy', 'like', '%' . $request->adjuntancy . '%');
        }

        $search = $search->orderBy('code', 'ASC')->get();

        // Gerar o PDF
        $pdf = PDF::loadView('attestPdf', ['attest' => $search])
            ->setPaper('a4', 'portrait');

        return $pdf->download('atestados.pdf');
    }
}

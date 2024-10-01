<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Situation;
use Illuminate\Http\Request;
use App\Http\Requests\ExperienceRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    // Inicializa a consulta base e carrega a relação com Situation
    $countExperience = experience::count();

    $search = experience::with('situation');

    // Adiciona filtro por código, se fornecido
    if ($request->filled('code')) {
        $search->where('code', 'like', '%' . $request->code . '%');
    }

    // Adiciona filtro por nome, se fornecido
    if ($request->filled('name')) {
        $search->where('name', 'like', '%' . $request->name . '%');
    }

    // Adiciona filtro por cargo, se fornecido
    if ($request->filled('adjuntancy')) {
        $search->where('adjuntancy', 'like', '%' . $request->adjuntancy . '%');
    }

    // Ordena de forma crescente pela coluna 'code' e paginar resultados
    $search = $search->orderBy('code', 'ASC')->paginate(10)->withQueryString();

    // Retorna a view com os dados filtrados e paginados
    return view('experience.index',
    [
        'experience' => $search,
        'count' => $countExperience
        ]);
    }


    public function create()
    {
        $situation = situation::orderBy('name', 'asc')->get();

        return view('experience.create',[
            'situation'=> $situation,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExperienceRequest $request)
    {
        $request->validated();

        try {
            // Cadastrar no banco de dados os valores de todos os campos
            $experience = experience::create([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
                'situation_id' => $request->situation_id,
            ]);

            // Redirecionar o usuário com a mensagem de sucesso
            return redirect()->route('experience.index')->with('success', 'Registro cadastrado com sucesso!');
        } catch (\Exception $e) {
            // Salvar log e redirecionar o usuário com a mensagem de erro
            Log::warning('Funcionário não cadastrado', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Há algum campo duplicado e/ou inválido!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $situation = situation::orderBy('name', 'asc')->get();
        $experience = experience::findOrFail($code);

        return view('experience.edit', [
            'experience' => $experience,
            'situation'=> $situation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExperienceRequest $request, $code)
    {
        $request->validated();
        $experience = experience::findOrFail($code);

        try {
            // Atualizar os dados do registro no banco de dados
            $experience->update([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'admission' => $request->admission,
                'contract1' => $request->contract1,
                'contract2' => $request->contract2,
                'salary' => str_replace(',', '.', str_replace('.', '', $request->salary)),
                'situation_id' => $request->situation_id,
            ]);

            // Salvar log e redirecionar o usuário com a mensagem de sucesso
            Log::info('Cadastro editado com sucesso', ['code' => $experience->code]);
            return redirect()->route('experience.index')->with('warning', 'Registro editado com sucesso!');
        } catch (\Exception $e) {
            // Salvar log e redirecionar o usuário com a mensagem de erro
            Log::warning('Cadastro não editado', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Cadastro não editado!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $experience = experience::where('code', $code)->firstOrFail();
        $experience->delete();

        return redirect()->route('experience.index')->with('danger', 'Registro deletado com sucesso!');
    }

    public function pdf(Request $request)
    {
    // Recuperar e pesquisar os registros do banco de dados com os mesmos filtros da listagem
    $search = experience::with('Situation');

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

    // Carregar a string com o HTML/conteúdo e determinar a orientação e o tamanho do arquivo
    $pdf = PDF::loadView('experiencePdf', ['experience' => $search])
        ->setPaper('a4', 'portrait');

    // Fazer o download do arquivo
    return $pdf->download('funcionários.pdf');
    }
    }

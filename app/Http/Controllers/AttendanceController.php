<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicializa a consulta base
        $countAttendance = attendance::count();
        $search = attendance::query();

        if ($request->filled('code')) {
            $search->where('code', 'like', '%' . $request->code . '%');
        }

        // Adiciona filtro por nome, se fornecido
        if ($request->filled('name')) {
            $search->where('name', 'like', '%' . $request->name . '%');
        }

        // Adiciona filtro por adjuntância (adjuntancy), se fornecido
        if ($request->filled('adjuntancy')) {
            $search->where('adjuntancy', 'like', '%' . $request->adjuntancy . '%');
        }

        // Ordena de forma crescente pela coluna 'code' e pagina os resultados
        $search = $search->orderBy('code', 'ASC')->paginate(10)->withQueryString();

        // Retorna a view com os dados filtrados e paginados
        return view('attendance.index', [
            'attendance' => $search,
            'count' => $countAttendance
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendance.create',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        $request->validated();

        try {
            // Cadastrar no banco de dados os valores de todos os campos
            $attendance = attendance::create([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'delay_date' => $request->delay_date,
                'arrival' => $request->arrival,
                'leave' => $request->leave,
                'motive' => $request->motive,
            ]);

            // Redirecionar o usuário com a mensagem de sucesso
            return redirect()->route('attendance.index')->with('success', 'Registro cadastrado com sucesso!');
        } catch (\Exception $e) {
            // Salvar log e redirecionar o usuário com a mensagem de erro
            Log::warning('Registro não cadastrado', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Registro não cadastrado!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $attendance = attendance::findOrFail($code);

        return view('attendance.edit', [
            'attendance' => $attendance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceRequest $request, $code)
    {
        $request->validated();
        $attendance = attendance::findOrFail($code);

        try {
            // Atualizar os dados do registro no banco de dados
            $attendance->update([
                'code' => $request->code,
                'name' => $request->name,
                'adjuntancy' => $request->adjuntancy,
                'delay_date' => $request->delay_date,
                'arrival' => $request->arrival,
                'leave' => $request->leave,
                'motive' => $request->motive,
            ]);

            // Salvar log e redirecionar o usuário com a mensagem de sucesso
            Log::info('Cadastro editado com sucesso', ['code' => $attendance->code]);
            return redirect()->route('attendance.index')->with('success', 'Registro editado com sucesso!');
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
        $attendance = attendance::findOrFail($code);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('danger', 'Registro deletado com sucesso!');
    }

    /**
     * Generate a PDF with the attendance records.
     */
    public function pdf(Request $request)
    {
        // Recuperar e pesquisar os registros do banco de dados com os mesmos filtros da listagem
        $search = attendance::query();

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
        $pdf = PDF::loadView('attendancePdf', ['attendance' => $search])
            ->setPaper('a4', 'portrait');

        // Fazer o download do arquivo
        return $pdf->download('atrasos.pdf');
    }
}

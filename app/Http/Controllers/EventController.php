<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('services.event.index');
    }

    public function getEvents()
    {
        // Carregar todos os funcionários
        $employees = Employee::all();

        // Mapear os dados dos aniversários dos funcionários ajustando o ano
        $birthdaysData = $employees->map(function ($employee) {
            $currentYear = Carbon::now()->year;

            // Ajustar a data de nascimento para o ano atual
            $birthdayThisYear = Carbon::parse($employee->birth_date)->year($currentYear);

            return [
                'title' => $employee->name,
                'start' => $birthdayThisYear->toDateString(),
                'end' => $birthdayThisYear->toDateString(),
                'comments' => 'Data de nascimento do funcionário',
            ];
        });

        // Mesclar os dados dos eventos e aniversários
        $allData = $birthdaysData;

        return response()->json($allData);
    }
}

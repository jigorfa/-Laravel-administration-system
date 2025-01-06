<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Employee;
use App\Models\OccurrenceDetail;
use App\Models\DelayDetail;
use App\Models\AttestDetail;
use App\Models\EpiDetail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form and handle salary calculations.
     */
    public function index(Request $request)
    {
        $countEmployee = Employee::count();
        $countAdjuntancy = Employee::distinct('adjuntancy')->count('adjuntancy');
        $countDelay = DelayDetail::count();
        $countAttest = AttestDetail::count();
        $countEpi = EpiDetail::count();
        $countOccurrence = OccurrenceDetail::count();
        $countSalary = Employee::sum('salary');

    
        // Inicializa os dados do cálculo salarial com valores padrão (0)
        $grossSalary = 0; 
        $monthlyWorkload = 0; 
        $hourlyRate = 0; 
        $extraHourPercentage = 0; 
        $extraHours = 0; 
        $extraHourRate = 0; 
        $totalExtraPay = 0; 
    
        // Verifica se é uma requisição POST para cálculo salarial
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'gross_salary' => 'required|numeric',
                'extra_hour_percentage' => 'required|numeric',
                'monthly_workload' => 'required|numeric',
                'extra_hours' => 'required|regex:/^\d{1,2}:\d{2}$/'
            ]);
    
            $grossSalary = $validatedData['gross_salary'];
            $extraHourPercentage = $validatedData['extra_hour_percentage'];
            $monthlyWorkload = $validatedData['monthly_workload'];
            $extraHoursInput = $validatedData['extra_hours'];
    
            // Processa as horas extras
            list($hours, $minutes) = explode(':', $extraHoursInput);
            $extraHours = (int) $hours + ((int) $minutes / 60);
    
            // Cálculos das horas extras
            $hourlyRate = $grossSalary / $monthlyWorkload;
            $extraHourRate = $hourlyRate * (1 + ($extraHourPercentage / 100));
            $totalExtraPay = $extraHourRate * $extraHours;
        }

        $topSalaries = Employee::select('adjuntancy', DB::raw('SUM(salary) as total_salary'))
        ->groupBy('adjuntancy')
        ->orderBy('total_salary', 'desc') // Ordena pelos salários totais em ordem decrescente
        ->take(5) // Limita aos 5 maiores
        ->get();

        // Consulta para contar a quantidade de funcionários por cargo
        $topAdjuntancys = Employee::select('adjuntancy', DB::raw('count(*) as total'))
        ->groupBy('adjuntancy')
        ->take(5) // Limita aos 5 principais cargos
        ->get();

        // Converter os dados para arrays separadamente (labels e totais)
        $adjuntancyLabels = $topAdjuntancys->pluck('adjuntancy')->toArray();
        $adjuntancyTotals = $topAdjuntancys->pluck('total')->toArray();

        // Consulta para contar as admissões por mês
        $admissions = Employee::select(DB::raw('MONTH(admission) as month'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('MONTH(admission)'))
        ->pluck('total', 'month')->toArray();

        // Consulta para contar os atrasos no mês
        $delays = DelayDetail::select(DB::raw('MONTH(delay_date) as month'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('MONTH(delay_date)'))
        ->pluck('total', 'month')->toArray();

        // Consulta para contar os atestados no mês
        $attests = AttestDetail::select(DB::raw('MONTH(start_attest) as month'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('MONTH(start_attest)'))
        ->pluck('total', 'month')->toArray();
        
        // Criar um array com 12 posições para representar cada mês (inicializa com 0)
        $monthlyAdmissions = array_fill(1, 12, 0);
        $monthlyOccurrences = array_fill(1, 12, 0);
        $monthlyAttests = array_fill(1, 12, 0);

        // Substituir os valores dos meses com os dados de admissões
        foreach ($admissions as $month => $total) {
            $monthlyAdmissions[$month] = $total;
        }

        // Preencher os meses corretos com os dados de atrasos
        foreach ($delays as $month => $total) {
            $monthlyOccurrences[$month] = $total;
        }

        // Preencher os meses corretos com os dados de atestados
        foreach ($attests as $month => $total) {
            $monthlyAttests[$month] = $total;
        }
    
        return view('dashboard', compact(
            'countEmployee',
            'countDelay',
            'countAttest',
            'countAdjuntancy',
            'countEpi',
            'countOccurrence',
            'countSalary',
            'grossSalary', 
            'monthlyWorkload', 
            'hourlyRate', 
            'extraHourPercentage', 
            'extraHours', 
            'extraHourRate', 
            'totalExtraPay',
            'topSalaries',
            'adjuntancyLabels',
            'adjuntancyTotals',
            'monthlyAdmissions',
            'monthlyOccurrences',
            'monthlyAttests'
        ));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

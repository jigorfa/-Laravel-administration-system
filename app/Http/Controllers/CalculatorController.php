<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        // Inicializa as variáveis com valores padrão
        $grossSalary = 0;
        $monthlyWorkload = 0;
        $hourlyRate = 0;
        $extraHourPercentage = 0;
        $extraHours = 0;
        $extraHourRate = 0;
        $totalExtraPay = 0;
        $totalSalary = 0;
        $vacationDays = 0;
        $vacationValue = 0;
        $bonusValue = 0;
        $totalValue = 0;
        $inssDiscount = 0;
        $irrfDiscount = 0;
        $netValue = 0;

        // Verifica se a sessão tem dados de cálculos anteriores e os exibe
        if (session('calculator_results')) {
            $results = session('calculator_results');
            $grossSalary = $results['gross_salary'];
            $monthlyWorkload = $results['monthly_workload'];
            $hourlyRate = $results['hourly_rate'];
            $extraHourPercentage = $results['extra_hour_percentage'];
            $extraHours = $results['extra_hours'];
            $extraHourRate = $results['extra_hour_rate'];
            $totalExtraPay = $results['total_extra_pay'];
            $totalSalary = $results['total_salary'];
            $vacationDays = $results['vacation_days'];
            $vacationValue = $results['vacation_value'];
            $bonusValue = $results['bonus_value'];
            $totalValue = $results['total_value'];
            $inssDiscount = $results['inss_discount'];
            $irrfDiscount = $results['irrf_discount'];
            $netValue = $results['net_value'];
        }

        // Retorna os valores para a view
        return view('services.calculator.index', compact(
            'grossSalary', 'monthlyWorkload', 'hourlyRate', 'extraHourPercentage', 'extraHours', 
            'extraHourRate', 'totalExtraPay','totalSalary', 'vacationDays', 'vacationValue', 'bonusValue', 
            'totalValue', 'inssDiscount', 'irrfDiscount', 'netValue'
        ));
    }


    public function calculateExtra(Request $request)
    {
        // Inicializa as variáveis com valores padrão
        $grossSalary = 0;
        $monthlyWorkload = 0;
        $hourlyRate = 0;
        $extraHourPercentage = 0;
        $extraHours = 0;
        $extraHourRate = 0;
        $totalExtraPay = 0;

        if ($request->isMethod('post')) {
            // Valida os dados da requisição
            $validatedData = $request->validate([
                'gross_salary' => 'required|numeric|min:0',
                'extra_hour_percentage' => 'required|numeric|min:0',
                'monthly_workload' => 'required|numeric|min:1', // Garantir carga horária positiva
                'extra_hours' => 'required|regex:/^\d{1,2}:\d{2}$/'
            ]);

            // Captura os valores validados
            $grossSalary = $validatedData['gross_salary'];
            $extraHourPercentage = $validatedData['extra_hour_percentage'];
            $monthlyWorkload = $validatedData['monthly_workload'];
            $extraHoursInput = $validatedData['extra_hours'];

            // Verifica se a carga horária mensal é válida
            if ($monthlyWorkload <= 0) {
                return back()->withErrors(['monthly_workload' => 'A carga horária mensal deve ser maior que zero.']);
            }

            // Converte as horas extras do formato "HH:MM" para horas decimais
            list($hours, $minutes) = explode(':', $extraHoursInput);
            $extraHours = (int)$hours + ((int)$minutes / 60);

            // Calcula o valor da hora normal
            $hourlyRate = $grossSalary / $monthlyWorkload;

            // Calcula o valor da hora extra
            $extraHourRate = $hourlyRate * (1 + ($extraHourPercentage / 100));

            // Calcula o total a ser pago pelas horas extras
            $totalExtraPay = $extraHourRate * $extraHours;
        }

        // Retorna os valores calculados
        return view('services.calculator.index', [
            'grossSalary' => $grossSalary,
            'monthlyWorkload' => $monthlyWorkload,
            'hourlyRate' => $hourlyRate,
            'extraHourPercentage' => $extraHourPercentage,
            'extraHours' => $extraHours,
            'extraHourRate' => $extraHourRate,
            'totalExtraPay' => $totalExtraPay,
            'totalSalary' => 0,
            'vacationDays' => 0,
            'vacationValue' => 0,
            'bonusValue' => 0,
            'totalValue' => 0,
            'inssDiscount' => 0,
            'irrfDiscount' => 0,
            'netValue' => 0,
        ]);
    }

    public function calculateVacation(Request $request)
    {
        $totalSalary = 0;
        $vacationDays = 0;
        $vacationValue = 0;
        $bonusValue = 0;
        $totalValue = 0;
        $inssDiscount = 0;
        $irrfDiscount = 0;
        $netValue = 0;
    
        // Valida os dados da requisição
        $validatedData = $request->validate([
            'total_salary' => 'required|numeric|min:0',
            'vacation_days' => 'required|numeric|min:0',
            'cash_bonus' => 'nullable|boolean', // Bônus de férias (opcional)
            'irrf_discount' => 'nullable|numeric|min:0', // IRRF é opcional, mas se for fornecido, deve ser numérico
        ]);
    
        // Captura os valores validados
        $totalSalary = $validatedData['total_salary'];
        $vacationDays = $validatedData['vacation_days'];
        $cashBonus = isset($validatedData['cash_bonus']) ? $validatedData['cash_bonus'] : false; // Valor booleano, default: false
        $irrfDiscount = isset($validatedData['irrf_discount']) ? $validatedData['irrf_discount'] : 0; // Valor numérico
    
        // Calcula o valor das férias
        $vacationValue = ($totalSalary / 30) * $vacationDays;
    
        // Calcula o bônus de férias (1/3 do valor das férias)
        $bonusValue = $cashBonus ? ($vacationValue / 3) : 0;
    
        // Calcula o valor total antes dos descontos
        $totalValue = $vacationValue + $bonusValue;
    
        // Calcula o desconto do INSS com base nas faixas
        if ($totalSalary <= 1412) {
            $inssDiscount = $totalSalary * 0.075;
        } elseif ($totalSalary <= 2666) {
            $inssDiscount = $totalSalary * 0.09;
        } elseif ($totalSalary <= 4000) {
            $inssDiscount = $totalSalary * 0.12;
        } else {
            $inssDiscount = $totalSalary * 0.14;
        }
    
        // Calcula o valor líquido
        $netValue = $totalValue - $inssDiscount - $irrfDiscount;
    
        // Retorna os valores calculados
        return view('services.calculator.index', [
            'totalSalary' => $totalSalary,
            'vacationDays' => $vacationDays,
            'vacationValue' => $vacationValue,
            'bonusValue' => $bonusValue,
            'totalValue' => $totalValue,
            'inssDiscount' => $inssDiscount,
            'irrfDiscount' => $irrfDiscount,
            'netValue' => $netValue,
            'grossSalary' => 0,
            'monthlyWorkload' => 0,
            'hourlyRate' => 0,
            'extraHourPercentage' => 0,
            'extraHours' => 0,
            'extraHourRate' => 0,
            'totalExtraPay' => 0,
        ]);
    }
    
}
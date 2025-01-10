<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Cálculos</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body class="animsition page-wrapper">
    @include('layouts.navigation')

    @if (session('success'))
        <div class="alert alert-success m-2" role="alert">
            <i class="fa-solid fa-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning m-2" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('warning') }}
        </div>
    @endif

    @if (session('danger'))
        <div class="alert alert-danger m-2" role="alert">
            <i class="fa-solid fa-trash"></i>
            {{ session('danger') }}
        </div>
    @endif

    <div class="page-content">
        <div class="section p-5">
            <div class="card col-lg-12 mx-auto">
                <div class="card-body">
                    <h1 class="m-b-35 text-center">Cálculo de horas extras</h1>
                    <hr>
                    <div class="row col-lg-12">
                        <div class="col-md-6">
                            <h4 class="text-center">Inserção de dados:</h4>
                            <div class="card mt-3">
                                <form class="m-3" id="salaryForm" action="{{ route('services.calculator.extra') }}" method="POST" onsubmit="return validateForm()">
                                    @csrf

                                    <div class="form-group">
                                        <label for="gross_salary" class="form-control-label">Salário bruto</label>
                                        <input type="text" class="form-control" id="gross_salary" name="gross_salary" required placeholder="R$ 0,00">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="monthly_workload" class="form-control-label">Carga horária mensal</label>
                                        <input type="number" class="form-control" id="monthly_workload" name="monthly_workload" required placeholder="Exemplo: 220 horas">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="extra_hour_percentage" class="form-control-label">Porcentagem das horas extras:</label>
                                        <input type="number" class="form-control" id="extra_hour_percentage" name="extra_hour_percentage" required placeholder="Exemplo: 50%">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="extra_hours" class="form-control-label">Quantidade de horas extras (HH:MM)</label>
                                        <input type="text" class="form-control" id="extra_hours" name="extra_hours" required placeholder="Exemplo: 10:30">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-calculator"></i> Calcular
                                        </button>

                                        <button type="reset" class="btn btn-warning text-light">
                                            <i class="fa-solid fa-eraser"></i> Limpar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="result-card">
                                <h4 class="text-center">Exibição de resultados:</h4>
                                <ul class="list-group mt-3">
                                    <li class="list-group-item text-center">Jornada prevista</li>
                                    <li class="list-group-item">
                                        <strong>Salário bruto:</strong>
                                        R$ {{ number_format($grossSalary, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Carga horária mensal:</strong>
                                        {{ $monthlyWorkload }} horas
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Salário por hora:</strong>
                                        R$ {{ number_format($hourlyRate, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item text-center">Jornada extra</li>
                                    <li class="list-group-item">
                                        <strong>Porcentagem das horas extras:</strong>
                                        {{ $extraHourPercentage }}%
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Valor total das horas:</strong>
                                        R$ {{ number_format($totalExtraPay, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Carga horária extra:</strong>
                                        {{ floor($extraHours) }} horas e {{ ($extraHours - floor($extraHours)) * 60 }} minutos
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Valor por hora:</strong>
                                        R$ {{ number_format($extraHourRate, 2, ',', '.') }}
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <a href="{{ route('services.calculator.index') }}" class="btn btn-danger mt-3">
                                        <i class="fas fa-undo"></i> Novo cálculo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-lg-12 mx-auto">
                <div class="section pt-3">
                    <h1 class="m-b-35 text-center">Cálculo de férias</h1>
                    <hr>
                    <div class="row col-lg-12">
                        <div class="col-md-6">
                            <h4 class="text-center">Inserção de dados:</h4>
                            <div class="card mt-3">
                                <form class="m-3" id="vacationForm" action="{{ route('services.calculator.vacation') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="total_salary" class="form-control-label">Salário Bruto</label>
                                        <input type="text" class="form-control" id="total_salary" name="total_salary" required placeholder="R$ 0,00">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="vacation_days" class="form-control-label">Quantidade de Dias de Férias</label>
                                        <input type="number" class="form-control" id="vacation_days" name="vacation_days" required placeholder="Exemplo: 20 dias">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="cash_bonus" class="form-control-label">Abono Pecuniário</label>
                                        <select class="form-control" id="cash_bonus" name="cash_bonus" required>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                        <small class="form-text text-muted">Escolha se o funcionário receberá o abono *</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="irrf_discount" class="form-control-label">Desconto IRRF</label>
                                        <input type="text" class="form-control" id="irrf_discount" name="irrf_discount" required placeholder="R$ 0,00">
                                        <small class="form-text text-muted">Campo obrigatório *</small>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-calculator"></i> Calcular
                                        </button>

                                        <button type="reset" class="btn btn-warning text-light">
                                            <i class="fa-solid fa-eraser"></i> Limpar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="result-card">
                                <h4 class="text-center">Exibição de Resultados:</h4>
                                <ul class="list-group mt-3 mb-3">
                                    <li class="list-group-item text-center">Cálculo de Férias</li>
                                    <li class="list-group-item">
                                        <strong>Salário Bruto:</strong>
                                        R$ {{ number_format($totalSalary, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Dias de Férias:</strong>
                                        {{ $vacationDays }} dias
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Valor das Férias:</strong>
                                        R$ {{ number_format($vacationValue, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Abono Pecuniário:</strong>
                                        R$ {{ number_format($bonusValue, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Valor Total (antes dos descontos):</strong>
                                        R$ {{ number_format($totalValue, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Desconto INSS:</strong>
                                        R$ {{ number_format($inssDiscount, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Desconto IRRF:</strong>
                                        R$ {{ number_format($irrfDiscount, 2, ',', '.') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Valor Líquido:</strong>
                                        R$ {{ number_format($netValue, 2, ',', '.') }}
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <a href="{{ route('services.calculator.index') }}" class="btn btn-danger mt-3">
                                        <i class="fas fa-undo"></i> Novo Cálculo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>

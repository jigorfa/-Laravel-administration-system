<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Painel de Gerenciamento</title>
    <link href="{{ url('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
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
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('layouts.navigation')
        <div class="page-content--bgf7">
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="col-lg-12 col-md-12">
                        <h1 class="text-center">Painel RH</h1>
                    </div>
                </div>
            </section>

            <section class="statistic2">
                <div class="container">
                    <h3 class="title-5 mb-3 text-center">Dados</h3>
                    <hr>
                    <div class="row m-t-45">
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countEmployee }} </h2>
                                <span class="desc">Funcionários</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-accounts"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countAdjuntancy }} </h2>
                                <span class="desc">Cargos</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-case"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countDelay }} </h2>
                                <span class="desc">Atrasos</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-time"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countOccurrence }} </h2>
                                <span class="desc">Ocorrências</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-alert-circle"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ 'R$ ' . number_format($countSalary, 2, ',', '.') }} </h2>
                                <span class="desc">Folha salarial (mensal)</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-money"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countAttest }} </h2>
                                <span class="desc">Atestados</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-hospital"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countEpi }} </h2>
                                <span class="desc">EPI's entregues</span>
                                <div class="icon">
                                    <i class="mdi mdi-hard-hat"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="statistic-chart">
                <div class="container">
                    <h3 class="title-5 m-b-35 text-center">Estatísticas</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="top-campaign">
                                <h3 class="title-3 m-b-30">Cargos com maiores salários</h3>
                                <div class="table-responsive">
                                    <table class="table table-top-campaign">
                                        <tbody>
                                            @foreach($topSalaries as $key => $salaries)
                                            <tr>
                                                <td>{{ $key + 1 }}. {{ $salaries->adjuntancy }}</td>
                                                <td>R$ {{ number_format($salaries->total_salary, 2, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="au-card m-b-30">
                                <div class="au-card-inner">
                                    <h3 class="title-2 m-b-40">Cargos com mais funcionários</h3>
                                    <canvas id="doughutChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="au-card m-b-30">
                                <div class="au-card-inner">
                                    <h3 class="title-2 m-b-40">Atestados e atrasos - Mensais</h3>
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="au-card m-b-30">
                                <div class="au-card-inner">
                                    <h3 class="title-2 m-b-40">Admissões - Mensais</h3>
                                    <canvas id="singelBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        var monthlyAdmissions = @json($monthlyAdmissions);
        var monthlyAttendances = @json($monthlyOccurrences);
        var monthlyAttests = @json($monthlyAttests);
        var adjuntancyLabels = @json($adjuntancyLabels);
        var adjuntancyTotals = @json($adjuntancyTotals);
    </script>
    
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js"') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/calculator.js') }}"></script>
</body>
</html>
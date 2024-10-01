<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Painel</title>
    <!-- Links -->
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
    <!-- CSS Principal -->
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
    <!-- Fim dos Links -->
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- Fim da Navbar -->

        <!-- Conteúdo -->
        <div class="page-content--bgf7">
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">Painel</h1>
                            <hr>
                            <h3 class="title-5 m-b-35 text-center">Quadros gerais</h3>
                        </div>
                    </div>
                </div>
            </section>
            <!-- informações -->
            <section class="statistic statistic2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countExperience }} </h2>
                                <span class="desc">Funcionários</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item">
                                <h2 class="number"> {{ $countAttendance }} </h2>
                                <span class="desc">Atrasos</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-time"></i>
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
                                <h2 class="number"> {{ 'R$ ' . number_format($totalSalary, 2, ',', '.') }} </h2>
                                <span class="desc">Folha salarial</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Fim das informações -->

            <!-- Gráficos -->
            <section class="statistic-chart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title-5 m-b-35 text-center">Estatísticas</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <!-- Gráfico 1 -->
                            <div class="statistic-chart-1">
                                <h3 class="title-3 m-b-30">chart</h3>
                                <div class="chart-wrap">
                                    <canvas id="widgetChart5"></canvas>
                                </div>
                                <div class="statistic-chart-1-note">
                                    <span class="big">10,368</span>
                                    <span>/ 16220 items sold</span>
                                </div>
                            </div>
                            <!-- Fim do Gráfico 1 -->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- Gráfico 2 -->
                            <div class="top-campaign">
                                <h3 class="title-3 m-b-30">top campaigns</h3>
                                <div class="table-responsive">
                                    <table class="table table-top-campaign">
                                        <tbody>
                                            <tr>
                                                <td>1. Australia</td>
                                                <td>$70,261.65</td>
                                            </tr>
                                            <tr>
                                                <td>2. United Kingdom</td>
                                                <td>$46,399.22</td>
                                            </tr>
                                            <tr>
                                                <td>3. Turkey</td>
                                                <td>$35,364.90</td>
                                            </tr>
                                            <tr>
                                                <td>4. Germany</td>
                                                <td>$20,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>5. France</td>
                                                <td>$10,366.96</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Fim do Gráfico 2 -->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- Gráfico 3 -->
                            <div class="chart-percent-2">
                                <h3 class="title-3 m-b-30">chart by %</h3>
                                <div class="chart-wrap">
                                    <canvas id="percent-chart2"></canvas>
                                    <div id="chartjs-tooltip">
                                        <table></table>
                                    </div>
                                </div>
                                <div class="chart-info">
                                    <div class="chart-note">
                                        <span class="dot dot--blue"></span>
                                        <span>products</span>
                                    </div>
                                    <div class="chart-note">
                                        <span class="dot dot--red"></span>
                                        <span>Services</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do Gráfico 3 -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- Fim dos Gráficos -->

            <!-- Copyright -->
                <!-- <section class="p-t-60 p-b-20">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            <!-- Fim do Copyright -->
        </div>
        <!-- Fim do Conteúdo -->
    </div>
    <!-- Scripts -->
    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/popper.min.js"') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ url ('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <!-- Main JS-->
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>
    <!-- Fim dos Scripts -->
</body>
</html>

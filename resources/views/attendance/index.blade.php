<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Atrasos</title>

    <!-- Fontfaces CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ url('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition page-wrapper">
    <!-- NAVBAR DESKTOP & MOBILE-->
    @include('layouts.navigation')
    <!-- END NAVBAR DESKTOP & MOBILE-->

    <!-- PAGE CONTENT-->
    <div class="page-content">
        <!-- WELCOME-->
        <section class="welcome p-t-10">
            <h1 class="text-center">Atrasos de funcionários(as)</h1>

            <div class="col-md-12">
                <hr>
                <div class="col-md-9 mx-auto">
                    <div class="card shadow">
                        <h4 class="card-header text-center">Campo de pesquisa</h4>
                        <div class="card-body">
                            <form action="{{ route('attendance.index') }}">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="code" class="control-label mb-1">Código</label>
                                            <input type="number" id="code" name="code" class="form-control text-center" placeholder="Busque pelo código:">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Nome</label>
                                            <input type="text" id="name" name="name" class="form-control text-center" placeholder="Busque pelo nome:">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label for="adjuntancy" class="control-label mb-1">Cargo</label>
                                        <div class="input-group">
                                            <input type="text" id="adjuntancy" name="adjuntancy" class="form-control text-center" placeholder="Busque pelo cargo:">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-sm text-light">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                    <a class="btn btn-warning btn-sm text-dark" href="{{ route('attendance.index') }}">
                                        <i class="fa-solid fa-chevron-left"></i> Voltar
                                    </a>
                                    <button type="reset" class="btn btn-danger btn-sm text-light">
                                        <i class="fa-solid fa-eraser"></i> Limpar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- DATA TABLE-->
                <div class="card mt-4 mb-4 border-light shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Registros: {{ $count }}</h3>
                        <span>
                            <button type="button">
                                <a href="{{ route('attendance.create') }}" class="btn btn-success text-light">
                                    <i class="fa-solid fa-plus"></i> Cadastrar
                                </a>
                            </button>

                            <button type="button">
                                <a href="{{ route('attendancePdf.generate', request()->query()) }}" class="btn btn-info text-light mr-2">
                                    <i class="fa-solid fa-print"></i> Imprimir
                                </a>
                            </button>
                        </span>
                    </div>

                    {{-- Verificar se existe a sessão success e imprimir o valor --}}
                    @if (session('success'))
                        <div class="alert alert-success m-3" role="alert">
                            <i class="fa-solid fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning m-3" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if (session('danger'))
                        <div class="alert alert-danger m-3" role="alert">
                        <i class="fa-solid fa-trash"></i>
                            {{ session('danger') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Chegada</th>
                                    <th scope="col">Saída</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col" class="text-center">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendance as $attendances)
                                    <tr>
                                        <th> {{ $attendances->code }} </th>
                                        <td>{{ $attendances->name }}</td>
                                        <td>{{ $attendances->adjuntancy }}</td>
                                        <td>{{ $attendances->delay_date }}</td>
                                        <td>{{ $attendances->arrival }}</td>
                                        <td>{{ $attendances->leave }}</td>
                                        <td>{{ $attendances->motive }}</td>

                                        <td class="d-md-flex justify-content-center">

                                            <form action="{{ route('attendance.edit', $attendances->code) }}" method="GET" class="mr-2">
                                                @csrf
                                                <button type="submit" class="btn btn-warning text-dark">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            </form>

                                            <form action="{{ route('attendance.destroy', $attendances->code) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger text-light"
                                                    onclick="return confirm('Tem certeza que deseja apagar este registro?')">
                                                    <i class="fa-solid fa-trash"></i> Apagar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-secondary m-3" role="alert">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>Nenhum registro encontrado</span>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $attendance->onEachSide(0)->links() }}
                    </div>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </section>
        <!-- END WELCOME-->
    </div>

    <!-- Jquery JS-->
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
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

    <!-- Main JS-->
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>

</body>

</html>

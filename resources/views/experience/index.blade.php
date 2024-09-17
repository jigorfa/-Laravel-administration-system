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
    <title>Experiência</title>

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
            <h1 class="text-center">Funcionários(as) em experiência</h1>

            <div class="col-md-12">
                <hr>
                <div class="col-md-6 mx-auto">
                    <div class="card shadow">
                        <h4 class="card-header text-center">Campo de pesquisa</h4>
                        <div class="card-body">
                            <form action="{{ route('experience.index') }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Nome</label>
                                            <input id="name" name="name" class="form-control" placeholder="Digite o nome do(a) funcionário(a)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="adjuntancy" class="control-label mb-1">Cargo</label>
                                        <div class="input-group">
                                            <input id="adjuntancy" name="adjuntancy" class="form-control" placeholder="Digite o cargo do(a) funcionário(a)">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-sm text-light">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                    <a class="btn btn-warning btn-sm text-dark" href="{{ route('experience.index') }}">
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
                        <h3>Listagem de registros</h3>
                        <span>
                            <button type="button">
                                <a href="{{ route('experience.create') }}" class="btn btn-success text-light">
                                    <i class="fa-solid fa-plus"></i> Cadastrar
                                </a>
                            </button>

                            <button type="button">
                                <a href="{{ route('pdf.generate', request()->query()) }}" class="btn btn-info text-light mr-2">
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
                                    <th scope="col">Situação</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Admissão</th>
                                    <th scope="col">1º Contrato</th>
                                    <th scope="col">2º Contrato</th>
                                    <th scope="col">Salário</th>
                                    <th scope="col" class="text-center">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Experience as $experiences)
                                    <tr>
                                        <th>{{ $experiences->code }}</th>
                                        <td>{{ $experiences->name }}</td>
                                        <td>{!! '<button class="btn btn-sm btn-'. $experiences->situation->color .'"disabled>' . $experiences->situation->name . '</button>' !!}</td>
                                        <td>{{ $experiences->adjuntancy }}</td>
                                        <td>{{ $experiences->admission }}</td>
                                        <td>{{ $experiences->contract1 }}</td>
                                        <td>{{ $experiences->contract2 }}</td>
                                        <td>{{ 'R$ ' . number_format($experiences->salary, 2, ',', '.') }}</td>

                                        <td class="d-md-flex justify-content-center">

                                            <form action="{{ route('experience.edit', $experiences->code) }}" method="GET" class="mr-2">
                                                @csrf
                                                <button type="submit" class="btn btn-warning text-dark">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            </form>

                                            <form action="{{ route('experience.destroy', $experiences->code) }}" method="POST">
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
                        {{ $Experience->onEachSide(0)->links() }}
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

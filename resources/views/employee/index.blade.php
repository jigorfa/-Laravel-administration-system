<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Funcionários</title>
    <!-- Links -->
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
    <!-- CSS Principal -->
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
    <!-- Fim dos links -->
</head>

<body class="animsition page-wrapper">
    <!-- Navbar -->
    @include('layouts.navigation')
    <!-- Fim da Navbar -->

    <!-- Início do Conteúdo -->
    <div class="page-content">
        <section class="welcome p-t-10">
            <h1 class="text-center">Funcionários(as)</h1>
            <div class="col-md-12 mt-3">
                <hr>
                <!-- Tabela -->
                <div class="card mt-4 mb-4 border-light shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3>
                            <i class="fa-solid fa-users"></i> |
                            {{ $countEmployee }} Fichas de funcionários
                        </h3>
                        
                        <span>
                            <button type="button">
                                <a href="{{ route('employee.create') }}" class="btn btn-success text-light">
                                    <i class="fa-solid fa-plus"></i> Cadastrar
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
                        <div class="card">
                            <!-- Pesquisa -->
                            <h4 class="card-header text-center">Pesquisa</h4>
                            <div class="card-body">
                                <form action="{{ route('employee.index') }}">
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
                                        <button type="button">
                                            <a href="{{ route('employee.index') }}" class="btn btn-warning btn-sm text-dark">
                                                <i class="fa-solid fa-chevron-left"></i> Voltar
                                            </a>
                                        </button>
                                        <button type="submit" class="btn btn-info btn-sm text-light">
                                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm text-light">
                                            <i class="fa-solid fa-eraser"></i> Limpar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Fim da pesquisa -->
                        </div>

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
                                @forelse ($employee as $employees)
                                    <tr>
                                        <th>{{ $employees->code }}</th>
                                        <td>{{ $employees->name }}</td>
                                        <td>{!! '<button class="btn btn-sm btn-'. $employees->situation->color .'"disabled>' . $employees->situation->name . '</button>' !!}</td>
                                        <td>{{ $employees->adjuntancy }}</td>
                                        <td>{{ $employees->admission }}</td>
                                        <td>{{ $employees->contract1 }}</td>
                                        <td>{{ $employees->contract2 }}</td>
                                        <td>{{ 'R$ ' . number_format($employees->salary, 2, ',', '.') }}</td>

                                        <td class="d-md-flex text-center justify-content-center">
                                            <button type="button">
                                                <a href="{{ route('employee.show', $employees->code) }}" class="btn btn-secondary text-light mr-2">
                                                    <i class="fa-solid fa-eye"></i> Ver
                                                </a>
                                            </button>

                                            <form action="{{ route('employee.edit', $employees->code) }}" method="GET" class="mr-2">
                                                @csrf
                                                <button type="submit" class="btn btn-warning text-dark">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            </form>

                                            <form action="{{ route('employee.destroy', $employees->code) }}" method="POST">
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
                        {{ $employee->onEachSide(0)->links() }}
                    </div>
                </div>
                <!-- Fim da tabela -->
            </div>
        </section>
    </div>

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

    <!-- Scripts -->
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
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
    <!-- JS Principal -->
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>
    <!-- Fim dos scripts -->
</body>
</html>

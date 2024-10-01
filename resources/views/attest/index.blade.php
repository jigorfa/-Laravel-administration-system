<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Atestados</title>
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

    <!-- Conteúdo -->
    <div class="page-content">
        <section class="welcome p-t-10">
            <h1 class="text-center">Atestados de funcionários(as)</h1>

            <div class="col-md-12">
                <hr>
                <div class="col-md-9 mx-auto">
                    <div class="card shadow">
                        <h4 class="card-header text-center">Campo de pesquisa</h4>
                        <div class="card-body">
                            <!-- Formulário de pesquisa -->
                            <form action="{{ route('attest.index') }}">
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
                                    <!-- Botões do formulário -->
                                    <button type="submit" class="btn btn-info btn-sm text-light">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                    <a class="btn btn-warning btn-sm text-dark" href="{{ route('attest.index') }}">
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

                <!-- Início da Tabela -->
                <div class="card mt-4 mb-4 border-light shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Registros: {{ $count }}</h3>
                        <span>
                            <button type="button">
                                <a href="{{ route('attest.create') }}" class="btn btn-success text-light">
                                    <i class="fa-solid fa-plus"></i> Cadastrar
                                </a>
                            </button>

                            <button type="button">
                                <a href="{{ route('attestPdf.generate', request()->query()) }}" class="btn btn-info text-light mr-2">
                                    <i class="fa-solid fa-print"></i> Imprimir
                                </a>
                            </button>
                        </span>
                    </div>

                    <!-- Mensagens de sucesso/erro -->
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
                        <!-- Início da tabela de registros -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Data de início</th>
                                    <th scope="col">Data de término</th>
                                    <th scope="col">Dias ausentes</th>
                                    <th scope="col">Causa social</th>
                                    <th scope="col">Arquivo</th>
                                    <th scope="col" class="text-center">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attest as $attests)
                                    <tr>
                                        <th>{{ $attests->code }}</th>
                                        <td>{{ $attests->name }}</td>
                                        <td>{{ $attests->adjuntancy }}</td>
                                        <td>{{ $attests->start_date }}</td>
                                        <td>{{ $attests->end_date }}</td>
                                        <td>{{ $attests->total_days }}</td>
                                        <td>{{ $attests->cause }}</td>
                                        <td>
                                            <!-- Verifica se há anexo -->
                                            @if ($attests->annex)
                                                <a href="{{ asset('img/attests/' . $attests->annex) }}" class="btn btn-success btn-sm" download>
                                                    <i class="fa-solid fa-download"></i> Baixar Arquivo
                                                </a>
                                            @else
                                                <span class="text-muted">Sem arquivo</span>
                                            @endif
                                        </td>

                                        <!-- Operações (Editar/Apagar) -->
                                        <td class="d-md-flex justify-content-center">
                                            <form action="{{ route('attest.edit', $attests->code) }}" method="GET" class="mr-2">
                                                @csrf
                                                <button type="submit" class="btn btn-warning text-dark">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                            </form>

                                            <form action="{{ route('attest.destroy', $attests->code) }}" method="POST">
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
                        <!-- Fim da tabela de registros -->
                        {{ $attest->onEachSide(0)->links() }}
                    </div>
                </div>
                <!-- Fim da Tabela -->
            </div>
        </section>
    </div>
    <!-- Fim do Conteúdo -->

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>
    <!-- Fim dos scripts -->
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>EPI's</title>
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

    <div class="page-content">
        <!-- WELCOME-->
        <section class="welcome p-t-10">
            <h1 class="text-center">EPI's</h1>
            <div class="col-md-12 mt-3">
                <hr>
                <div class="card mt-4 mb-4 border-light shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">                        
                        <h3>
                            <i class="fa-solid fa-helmet-safety"></i> |
                            {{ $search->total() }} EPI's entregues
                        </h3>
                        <div class="d-flex align-occurrencess-center">
                            <div>
                                <button type="button">
                                    <a href="{{ route('sst.epi.create') }}" class="btn btn-success text-light">
                                        <i class="fa-solid fa-plus"></i> Cadastrar
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
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
                            <h4 class="card-header text-center">Pesquisa</h4>
                            <div class="card-body">
                                <form action="{{ route('sst.epi.index') }}">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="enterprise_id" class="control-label mb-1">Empresa</label>
                                                <select name="search_enterprise" id="search_enterprise" class="form-control">
                                                    <option value="" class="text-center">Busque pela empresa:</option>
                                                    @forelse ($enterprises as $enterprise)
                                                        <option value="{{ $enterprise->id }}" class="text-center" 
                                                            {{ request('enterprise_id') == $enterprise->id ? 'selected' : '' }}>
                                                            {{ $enterprise->name }} 
                                                        </option>
                                                    @empty
                                                        <option value="">Nenhuma empresa encontrada</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="code" class="control-label mb-1">Código</label>
                                                <input type="number" id="code" name="search_code" class="form-control text-center" placeholder="Busque pelo código:" value="{{ request('code') }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Nome</label>
                                                <input type="text" id="name" name="search_name" class="form-control text-center" placeholder="Busque pelo nome:" value="{{ request('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label for="adjuntancy" class="control-label mb-1">Cargo</label>
                                            <div class="input-group">
                                                <input type="text" id="adjuntancy" name="search_adjuntancy" class="form-control text-center" placeholder="Busque pelo cargo:" value="{{ request('adjuntancy') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button">
                                            <a href="{{ route('sst.epi.index') }}" class="btn btn-warning btn-sm text-dark">
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
                        </div>
                    
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Quantidade de registros</th>
                                    <th scope="col" class="text-center">Operações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($search as $epis)
                                    <tr class="occurrence-row">
                                    <th>{{ $epis->employee->code }}</th>
                                    <td>{{ $epis->employee->name }}</td>
                                    <td>{{ $epis->employee->adjuntancy }}</td>
                                    <td>{{ $epis->detail->count() }}</td>

                                    <td class="d-md-flex justify-content-center">
                                        <button type="button">
                                            <a href="{{ route('sst.epi.show', $epis->id) }}" class="btn btn-secondary text-light mr-2">
                                                <i class="fa-solid fa-eye"></i> Ver
                                            </a>
                                        </button>

                                        <form action="{{ route('sst.epi.edit',$epis->id) }}" method="GET" class="mr-2">
                                            @csrf
                                            <button type="submit" class="btn btn-warning text-dark">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </button>
                                        </form>

                                        <form action="{{ route('sst.epi.destroy', $epis->id) }}" method="POST">
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
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div role="alert" class="alert alert-secondary m-3" id="alert_message">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                <span>Nenhum registro encontrado</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $search->onEachSide(0)->links() }}
                    </div>
                </div>
            </div>
        </section>
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
    <script src="{{ url('assets/dashboard/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>
</body>
</html>
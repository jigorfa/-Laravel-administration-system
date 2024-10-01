<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Cadastro</title>
    <!-- links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url ('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <!-- CSS Principal -->
    <link href="{{ url ('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
    <!-- Fim dos links -->
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- Fim da navbar -->

        <!-- Conteúdo -->
        <div class="page-content">
            <section class="welcome p-t-10 col-md-12">
                <div>
                    <h1 class="text-center">Cadastrar registro</h1>

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Ops !</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->all())
                        <div class="alert alert-danger" role="alert" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Por favor, corrija os seguintes erros:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="list-style: none; padding-left: 0;"> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="card bg-light text-dark">
                    <div class="card-body card-block">
                        <!-- Container -->
                        <div class="d-flex justify-content-center">
                            <div class="col-md-9">
                                <form action="{{ route('attest.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group">
                                        <label for="code" class="form-control-label">Código *</label>
                                        <input type="number" id="code" name="code" placeholder="Insira o código do(a) funcionário(a): " class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Nome *</label>
                                        <input type="text" id="name" name="name" placeholder="Insira o nome do(a) funcionário(a): " class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="adjuntancy" class="form-control-label">Cargo *</label>
                                        <input type="text" id="adjuntancy" name="adjuntancy" placeholder="Insira o cargo do(a) funcionário(a): " class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date" class="form-control-label">Data de início *</label>
                                        <input type="date" id="start_date" name="start_date" placeholder="Insira a data de início do atestado: *" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date" class="form-control-label">Data de término *</label>
                                        <input type="date" id="end_date" name="end_date" placeholder="Insira a data de término do atestado: *" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="cause" class="form-control-label">Causa social *</label>
                                        <input type="text" id="cause" name="cause" placeholder="Insira a causa do atestado: *" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="annex" class="form-control-label">Anexo *</label>
                                        <input type="file" id="annex" name="annex" placeholder="Insira um arquivo do atestado: *" class="form-control">
                                        <small class="form-text text-muted">Formato permitido: PDF</small>
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-success text-dark mr-2">
                                            <i class="fa-solid fa-plus"></i> Cadastrar
                                        </button>

                                        <button type="reset" class="btn btn-warning text-dark mr-2">
                                            <i class="fa-solid fa-trash"></i> Limpar
                                        </button>

                                        <button type="button">
                                            <a href="{{ route('attest.index') }}" class="btn btn-danger text-dark">
                                                <i class="fa-solid fa-x"></i> Cancelar
                                            </a>
                                        </button>
                                    </div>
                                </form>
                          /div>
                        </div>
                        <!-- Fim do Container -->
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Links -->
    <script src="{{ url ('assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ url ('assets/login/js/popper.js') }}"></script>
    <script src="{{ url ('assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ url ('assets/login/js/main.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/popper.min.js"') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
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
    <!-- JS Principal -->
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>
    <!-- Fim dos links -->
</body>
</html>

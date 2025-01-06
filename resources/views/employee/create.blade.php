<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Cadastro - Funcionário</title>
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
    <!-- fim dos links -->
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
                    <h1 class="text-center">Cadastro de funcionário</h1>

                    <!-- Verificação de erros -->
                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Ops!</strong> {{ session('error') }}
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
                    <!-- Fim da verificação de erros -->
                </div>
                
                <div class="card bg-light text-dark mt-3">
                    <div class="card-body card-block">
                        <!-- Container -->
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-9">
                                <form action="{{ route('employee.store') }}" method="POST">
                                    @csrf

                                    <h4>Informações documentais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="code" class="form-control-label">Código</label>
                                            <input type="number" id="code" name="code" placeholder="Insira o código:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="ctps_code" class="form-control-label">CTPS</label>
                                            <input type="number" id="ctps_code" name="ctps_code" placeholder="Insira a CTPS:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="pis_code" class="form-control-label">PIS</label>
                                            <input type="number" id="pis_code" name="pis_code" placeholder="Insira o PIS:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="instruction_id" class="form-control-label">Grau de instrução</label>
                                            <select name="instruction_id" id="instruction_id" class="form-control" required>
                                                <option value="">Selecione o grau:</option>
                                                @forelse ($instruction as $instructions)
                                                    <option value="{{ $instructions->id }}"
                                                        {{ old('instruction_id') == $instructions->id}}>
                                                        {{ $instructions->name }}</option>
                                                @empty
                                                    <option value="">Nenhum grau de instrução encontrado</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="personal_code" class="form-control-label">CPF</label>
                                            <input type="text" id="personal_code" name="personal_code" placeholder="Insira o CPF:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="vote_code" class="form-control-label">Título de eleitor</label>
                                            <input type="number" id="vote_code" name="vote_code" placeholder="Insira o título de eleitor:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="birth_date" class="form-control-label">Data de nascimento</label>
                                            <input type="date" id="birth_date" name="birth_date" placeholder="Insira a data de nascimento:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="telephone" class="form-control-label">Telefone</label>
                                            <input type="text" id="telephone" name="telephone" placeholder="Exemplo: (85) 9 1111-2222" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="name" class="form-control-label">Nome</label>
                                            <input type="text" id="name" name="name" placeholder="Insira o nome do(a) funcionário(a):" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="adjuntancy" class="form-control-label">Cargo</label>
                                            <input type="text" id="adjuntancy" name="adjuntancy" placeholder="Insira o cargo do(a) funcionário(a):" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <h4>Informações residenciais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="state" class="form-control-label">Estado</label>
                                            <input type="text" id="state" name="state" placeholder="Exemplo: Ceará" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="city" class="form-control-label">Cidade</label>
                                            <input type="text" id="city" name="city" placeholder="Exemplo: Fortaleza" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="neighborhood" class="form-control-label">Bairro</label>
                                            <input type="text" id="neighborhood" name="neighborhood" placeholder="Exemplo: Aldeota" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="number" class="form-control-label">Número</label>
                                            <input type="number" id="number" name="number" placeholder="Exemplo: 225" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="postal_code" class="form-control-label">CEP</label>
                                            <input type="number" id="postal_code" name="postal_code" placeholder="Exemplo: 60175-084" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-9">
                                            <label for="street" class="form-control-label">Logradouro</label>
                                            <input type="text" id="street" name="street" placeholder="Exemplo: Rua Fonseca Lobo" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <h4>Informações contratuais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="admission" class="form-control-label">Admissão</label>
                                            <input type="date" id="admission" name="admission" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="contract1" class="form-control-label">1º Contrato</label>
                                            <input type="date" id="contract1" name="contract1" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="contract2" class="form-control-label">2º Contrato</label>
                                            <input type="date" id="contract2" name="contract2" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="salary" class="form-control-label">Salário (R$)</label>
                                            <input type="text" id="salary" name="salary" placeholder="Insira o salário:" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="situation_id" class="form-label">Situação</label>
                                            <select name="situation_id" id="situation_id" class="form-control" required>
                                                <option value="">Selecione a situação:</option>
                                                @forelse ($situation as $situations)
                                                    <option value="{{ $situations->id }}"
                                                        {{ old('situation_id') == $situations->id}}>
                                                        {{ $situations->name }}</option>
                                                @empty
                                                    <option value="">Nenhuma situação da conta encontrada</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success text-light mr-2">
                                            <i class="fa-solid fa-plus"></i> Cadastrar
                                        </button>

                                        <button type="reset" class="btn btn-warning text-dark mr-2">
                                            <i class="fa-solid fa-eraser"></i> Limpar
                                        </button>

                                        <button type="button">
                                            <a href="{{ route('employee.index') }}" class="btn btn-danger text-light">
                                                <i class="fa-solid fa-x"></i> Cancelar
                                            </a>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Fim do Container -->
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Scripts -->
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
    <!-- Fim dos scripts -->
</body>
</html>

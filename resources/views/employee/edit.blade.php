<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Edição - Funcionário</title>
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
                    <div class="text-center">
                        <h1>Edição de funcionário</h1>
                        <h4 class="mt-2">Registro: {{ old('name', $employee->name) }} </h4>
                    </div>

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
                                <form action="{{ route('employee.update', $employee->code) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <h4>Informações documentais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="code" class="form-control-label">Código</label>
                                            <input type="number" class="form-control" id="code" name="code" value="{{ old('code', $employee->code) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="ctps_code" class="form-control-label">CTPS</label>
                                            <input type="number" class="form-control" id="ctps_code" name="ctps_code"  value="{{ old('ctps_code', $employee->ctps_code) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="pis_code" class="form-control-label">PIS</label>
                                            <input type="number" class="form-control" id="pis_code" name="pis_code" value="{{ old('pis_code', $employee->pis_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="instruction_id" class="form-control-label">Grau de instrução</label>
                                            <select name="instruction_id" class="form-control" id="instruction_id" required>
                                                <option value="">Selecione o grau:</option>
                                                @forelse ($instruction as $instructions)
                                                    <option value="{{ $instructions->id }}"
                                                        {{ old('situation_id', $employee->instruction_id) == $instructions->id ? 'selected' : '' }}>
                                                        {{ $instructions->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma situação da conta encontrada</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="personal_code" class="form-control-label">CPF</label>
                                            <input type="text" class="form-control" id="personal_code" name="personal_code"  value="{{ old('personal_code', $employee->personal_code) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="vote_code" class="form-control-label">Título de eleitor</label>
                                            <input type="number" class="form-control" id="vote_code" name="vote_code" value="{{ old('vote_code', $employee->vote_code) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="birth_date" class="form-control-label">Data de nascimento</label>
                                            <input type="date" class="form-control" id="birth_date" name="birth_date"  value="{{ old('birth_date', $employee->birth_date) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="telephone" class="form-control-label">Telefone</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $employee->telephone) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="name" class="form-control-label">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" name="name" value="{{ old('name', $employee->name) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="adjuntancy" class="form-control-label">Cargo</label>
                                            <input type="text" class="form-control" id="adjuntancy" name="adjuntancy" value="{{ old('adjuntancy', $employee->adjuntancy) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <h4>Informações residenciais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="state" class="form-control-label">Estado</label>
                                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $employee->state) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="city" class="form-control-label">Cidade</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $employee->city) }}"  required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="neighborhood" class="form-control-label">Bairro</label>
                                            <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $employee->neighborhood) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="number" class="form-control-label">Número</label>
                                            <input type="number" class="form-control" id="number" name="number" value="{{ old('number', $employee->number) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="postal_code" class="form-control-label">CEP</label>
                                            <input type="number" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $employee->postal_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-9">
                                            <label for="street" class="form-control-label">Logradouro</label>
                                            <input type="text" class="form-control" id="street" name="street" value="{{ old('street', $employee->street) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <h4>Informações contratuais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="admission" class="form-control-label">Admissão</label>
                                            <input type="date" id="admission" name="admission" value="{{ old('admission', $employee->admission) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="contract1" class="form-control-label">1º Contrato</label>
                                            <input type="date" id="contract1" name="contract1" value="{{ old('contract1', $employee->contract1) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="contract2" class="form-control-label">2º Contrato</label>
                                            <input type="date" id="contract2" name="contract2" value="{{ old('contract2', $employee->contract2) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="salary" class="form-control-label">Salário (R$)</label>
                                            <input type="text" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="demission" class="form-control-label">Demissão/Encerramento</label>
                                            <input type="date" id="demission" name="demission" value="{{ old('demission', $employee->demission) }}" class="form-control">
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="situation_id" class="form-label">Situação</label>
                                            <select name="situation_id" id="situation_id" class="form-control">
                                                <option value="">Selecione o grau:</option>
                                                @forelse ($situation as $situations)
                                                    <option value="{{ $situations->id }}"
                                                        {{ old('situation_id', $employee->situation_id) == $situations->id ? 'selected' : '' }}>
                                                        {{ $situations->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma situação da conta encontrada</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="enterprise_id" class="form-control-label">Empresa</label>
                                            <select name="enterprise_id" class="form-control" id="enterprise_id" required>
                                                <option value="">Selecione a empresa:</option>
                                                @forelse ($enterprise as $enterprises)
                                                    <option value="{{ $enterprises->id }}"
                                                        {{ old('enterprise_id', $employee->enterprise_id) == $enterprises->id ? 'selected' : '' }}>
                                                        {{ $enterprises->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma situação da conta encontrada</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success text-light mr-2">
                                            <i class="fa-solid fa-check"></i> Editar
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

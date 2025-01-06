<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Visualização - Funcionário</title>
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
                        <h1>Visualização de funcionário</h1>
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
        
                                <h4>Informações documentais:</h4>
                                <div class="row mt-3">
                                    <div class="form-group col-lg-3">
                                        <label for="code" class="form-control-label">Código</label>
                                        <input type="number" id="code" name="code" value="{{ $employee->code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="ctps_code" class="form-control-label">CTPS</label>
                                        <input type="number" id="ctps_code" name="ctps_code"  value="{{ $employee->ctps_code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="pis_code" class="form-control-label">PIS</label>
                                        <input type="number" id="pis_code" name="pis_code" value="{{ $employee->pis_code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="instruction_id" class="form-control-label">Grau de instrução</label>
                                        <select name="instruction_id" id="instruction_id" class="form-control" disabled>
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
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="personal_code" class="form-control-label">CPF</label>
                                        <input type="text" id="personal_code" name="personal_code"  value="{{ $employee->personal_code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="vote_code" class="form-control-label">Título de eleitor</label>
                                        <input type="number" id="vote_code" name="vote_code" value="{{ $employee->vote_code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="birth_date" class="form-control-label">Data de nascimento</label>
                                        <input type="date" id="birth_date" name="birth_date"  value="{{ $employee->birth_date }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="telephone" class="form-control-label">Telefone</label>
                                        <input type="text" id="telephone" name="telephone" value="{{ $employee->telephone }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="name" class="form-control-label">Nome</label>
                                        <input type="text" id="name" name="name" name="name" value="{{ $employee->name }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="adjuntancy" class="form-control-label">Cargo</label>
                                        <input type="text" id="adjuntancy" name="adjuntancy" value="{{ $employee->adjuntancy }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                </div>

                                <h4>Informações residenciais:</h4>
                                <div class="row mt-3">
                                    <div class="form-group col-lg-3">
                                        <label for="state" class="form-control-label">Estado</label>
                                        <input type="text" id="state" name="state" value="{{ $employee->state }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="city" class="form-control-label">Cidade</label>
                                        <input type="text" id="city" name="city" value="{{ $employee->city }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="neighborhood" class="form-control-label">Bairro</label>
                                        <input type="text" id="neighborhood" name="neighborhood" value="{{ $employee->neighborhood }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="number" class="form-control-label">Número</label>
                                        <input type="number" id="number" name="number" value="{{ $employee->number }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="postal_code" class="form-control-label">CEP</label>
                                        <input type="number" id="postal_code" name="postal_code" value="{{  $employee->postal_code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-9">
                                        <label for="street" class="form-control-label">Logradouro</label>
                                        <input type="text" id="street" name="street" value="{{ $employee->street }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                </div>

                                <h4>Informações contratuais:</h4>
                                <div class="row mt-3">
                                    <div class="form-group col-lg-3">
                                        <label for="admission" class="form-control-label">Admissão</label>
                                        <input type="date" id="admission" name="admission" value="{{ $employee->admission }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="contract1" class="form-control-label">1º Contrato</label>
                                        <input type="date" id="contract1" name="contract1" value="{{ $employee->contract1 }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="contract2" class="form-control-label">2º Contrato</label>
                                        <input type="date" id="contract2" name="contract2" value="{{ $employee->contract2 }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="salary" class="form-control-label">Salário (R$)</label>
                                        <input type="text" id="salary" name="salary" value="{{ $employee->salary }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="situation_id" class="form-label">Situação</label>
                                        <select name="situation_id" id="situation_id" class="form-control" disabled>
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
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button">
                                        <a href="{{ route('pdf.employee',  $employee->code) }}" class="btn btn-info text-light mr-2">
                                            <i class="fa-solid fa-print"></i> Imprimir
                                        </a>
                                    </button>

                                    <button type="button">
                                        <a href="{{ route('employee.index') }}" class="btn btn-warning text-dark">
                                            <i class="fa-solid fa-chevron-left"></i> Voltar
                                        </a>
                                    </button>
                                </div>
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

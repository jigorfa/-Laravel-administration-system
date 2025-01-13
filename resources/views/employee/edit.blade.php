<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Edição - Funcionário</title>
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
    <link href="{{ url ('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body class="animsition">
    <div class="page-wrapper">

        @include('layouts.navigation')

        <div class="page-content">
            <section class="welcome p-t-10 col-md-12">
                <div>
                    <div class="text-center">
                        <h1>Edição de funcionário</h1>
                        <h4 class="mt-2">Registro: {{ old('name', $employee->name) }} </h4>
                    </div>

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
                </div>
                
                <div class="card bg-light text-dark mt-3">
                    <div class="card-body card-block">
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-9">
                                <form action="{{ route('employee.update', $employee->code) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <h4>Informações documentais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-9">
                                            <label for="name" class="form-control-label">Nome</label>
                                            <input type="text" id="name" name="name" placeholder="Insira o nome completo do(a) funcionário(a):" class="form-control" value="{{ old('name', $employee->name) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="birth_date" class="form-control-label">Data de nascimento</label>
                                            <input type="date" id="birth_date" name="birth_date" class="form-control" value="{{ old('birth_date', $employee->birth_date) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="nationality" class="form-control-label">Nacionalidade</label>
                                            <input type="text" id="nationality" name="nationality" placeholder="Insira a nacionalidade" class="form-control" value="{{ old('nationality', $employee->nationality) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="naturalness" class="form-control-label">Naturalidade</label>
                                            <input type="text" id="naturalness" name="naturalness" placeholder="Insira a naturalidade" class="form-control" value="{{ old('naturalness', $employee->naturalness) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="color_id" class="form-control-label">Cor/Raça</label>
                                            <select name="color_id" id="color_id" class="form-control" required>
                                                <option value="">Selecione a cor/raça:</option>
                                                @forelse ($color as $colors)
                                                    <option value="{{ $colors->id }}"
                                                        {{ old('gender_id', $employee->color_id) == $colors->id ? 'selected' : '' }}>
                                                        {{ $colors->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhum tipo de cor/raça encontrada</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="gender_id" class="form-control-label">Sexo</label>
                                            <select name="gender_id" id="gender_id" class="form-control" required>
                                                <option value="">Selecione o sexo:</option>
                                                @forelse ($gender as $genders)
                                                    <option value="{{ $genders->id }}"
                                                        {{ old('gender_id', $employee->gender_id) == $genders->id ? 'selected' : '' }}>
                                                        {{ $genders->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhum tipo de sexo encontrado</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="cpf_code" class="form-control-label">CPF</label>
                                            <input type="text" id="cpf_code" name="cpf_code" placeholder="Insira o CPF:" class="form-control" value="{{ old('cpf_code', $employee->cpf_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="ctps_code" class="form-control-label">CTPS</label>
                                            <input type="number" id="ctps_code" name="ctps_code" placeholder="Insira a CTPS:" class="form-control" value="{{ old('ctps_code', $employee->ctps_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="pis_code" class="form-control-label">PIS/PASEP</label>
                                            <input type="number" id="pis_code" name="pis_code" placeholder="Insira o PIS/PASEP:" class="form-control" value="{{ old('pis_code', $employee->pis_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="vote_code" class="form-control-label">Título de eleitor</label>
                                            <input type="text" id="vote_code" name="vote_code" placeholder="Insira o título de eleitor:" class="form-control" value="{{ old('vote_code', $employee->vote_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="cnh_code" class="form-control-label">CNH</label>
                                            <input type="text" id="cnh_code" name="cnh_code" placeholder="Insira o número da CNH:" class="form-control" value="{{ old('cnh_code', $employee->cnh_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="telephone" class="form-control-label">Telefone</label>
                                            <input type="text" id="telephone" name="telephone" placeholder="Exemplo: (85) 9 1111-2222" class="form-control" value="{{ old('telephone', $employee->telephone) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="instruction_id" class="form-control-label">Grau de instrução</label>
                                            <select name="instruction_id" id="instruction_id" class="form-control" required>
                                                <option value="">Selecione o grau:</option>
                                                @forelse ($instruction as $instructions)
                                                    <option value="{{ $instructions->id }}"
                                                        {{ old('instruction_id', $employee->instruction_id) == $instructions->id ? 'selected' : '' }}>
                                                        {{ $instructions->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhum grau de instrução encontrado</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="civil_state_id" class="form-control-label">Estado Civil</label>
                                            <select name="civil_state_id" id="civil_state_id" class="form-control" required>
                                                <option value="">Selecione o estado civil:</option>
                                                @forelse ($civilState as $civilStates)
                                                    <option value="{{ $civilStates->id }}"
                                                        {{ old('civil_state_id', $employee->civil_state_id) == $civilStates->id ? 'selected' : '' }}>
                                                        {{ $civilStates->name }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhum tipo de estado civil</option>
                                                @endforelse
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                    </div>

                                    <h4>Informações residenciais:</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-3">
                                            <label for="postal_code" class="form-control-label">CEP</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $employee->postal_code) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-9">
                                            <label for="address" class="form-control-label">Logradouro</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $employee->address) }}" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                    </div>

                                    <h4>Informações contratuais:</h4>
                                    <div class="row mt-3">
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

                                        <div class="form-group col-lg-3">
                                            <label for="situation_id" class="form-label">Situação</label>
                                            <select name="situation_id" id="situation_id" class="form-control" required>
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
                                            <label for="code" class="form-control-label">Código</label>
                                            <input type="number" id="code" name="code" placeholder="Insira o código:" value="{{ old('code', $employee->code) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="adjuntancy" class="form-control-label">Cargo</label>
                                            <input type="text" id="adjuntancy" name="adjuntancy" placeholder="Insira o cargo:" value="{{ old('code', $employee->adjuntancy) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="admission" class="form-control-label">Admissão</label>
                                            <input type="date" id="admission" name="admission" value="{{ old('admission', $employee->admission) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="contract1" class="form-control-label">1º Contrato</label>
                                            <input type="date" id="contract1" name="contract1" value="{{ old('contract1', $employee->contract1) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="contract2" class="form-control-label">2º Contrato</label>
                                            <input type="date" id="contract2" name="contract2" value="{{ old('contract2', $employee->contract2) }}" class="form-control" required>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="demission" class="form-control-label">Demissão/Encerramento</label>
                                            <input type="date" id="demission" name="demission" value="{{ old('demission', $employee->demission) }}" class="form-control">
                                            <small class="form-text text-muted">Campo facultativo *</small>
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="salary" class="form-control-label">Salário (R$)</label>
                                            <input type="text" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" class="form-control" required>
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
                    </div>
                </div>
            </section>
        </div>
    </div>

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
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>
</body>
</html>
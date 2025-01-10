<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualização - Ocorrências</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url('assets/dashboard/css/font-face.css') }}" rel="stylesheet">
    <link href="{{ url('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet">
</head>
<body class="animsition bg-light">
    <div class="page-wrapper">
        @include('layouts.navigation')
        <div class="page-content">
            <section class="welcome p-t-10 col-md-12">
                <div>
                    <div class="text-center">
                        <h1>Visualização de ocorrências</h1>
                        <h4 class="mt-2">Registro: {{ $occurrence->employee->name }} </h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                
                <div class="card bg-light text-dark mt-3">
                    <div class="card-body card-block">
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-9">
                                <h4>Informações de identificação</h4>
                                <div class="row mt-3">
                                    <div class="form-group col-lg-4">
                                        <label>Código</label>
                                        <input type="number" name="employee_code" value="{{ $occurrence->employee->code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Cargo</label>
                                        <input type="text" name="adjuntancy" value="{{ $occurrence->employee->adjuntancy }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Nome</label>
                                        <input type="text" name="name" value="{{ $occurrence->employee->name }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável *</small>
                                    </div>
                                </div>
                                <h4>Informações das ocorrências</h4>
                                <div id="occurrence_info_container">
                                    @foreach($occurrence->detail as $details)
                                        <div class="row mt-3 occurrence-group">
                                            <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                            <div class="form-group col-lg-3">
                                                <label>Data da ocorrência</label>
                                                <input type="date" name="detail[{{ $loop->index }}][occurrence_date]" value="{{ $details->occurrence_date }}" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="occasion_id_{{ $loop->index }}">Tipo da ocorrência</label>
                                                <select id="occasion_id_{{ $loop->index }}" name="detail[{{ $loop->index }}][occasion_id]" class="form-control" disabled>
                                                    <option value="" disabled>Selecione...</option>
                                                    @foreach ($occasion as $occasions)
                                                        <option value="{{ $occasions->id }}" 
                                                            {{ $details->occasion_id == $occasions->id ? 'selected' : '' }}>
                                                            {{ $occasions->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Descrição</label>
                                                <input type="text" name="detail[{{ $loop->index }}][description]" value="{{ $details->description }}" placeholder="Insira uma descrição sobre a ocorrência" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button">
                                        <a href="{{ route('pdf.occurrence',  $occurrence->id) }}" class="btn btn-info text-light mr-2">
                                            <i class="fa-solid fa-print"></i> Imprimir
                                        </a>
                                    </button>
                                    
                                    <button type="button">
                                        <a href="{{ route('binder.occurrence.index') }}" class="btn btn-warning text-dark">
                                            <i class="fa-solid fa-chevron-left"></i> Voltar
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>
</body>
</html>
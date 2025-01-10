<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags e Títulos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualização - Atrasos</title>
    <!-- Estilos -->
    <link href="https:
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
                        <h1>Visualização de atrasos</h1>
                        <h4 class="mt-2">Registro: {{ $delay->employee->name }} </h4>
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
                                <!-- Informações de Identificação -->
                                <h4>Informações de identificação</h4>
                                <div class="row mt-3">
                                    <div class="form-group col-lg-4">
                                        <label>Código</label>
                                        <input type="number" name="employee_code" value="{{ $delay->employee->code }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável*</small>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Cargo</label>
                                        <input type="text" name="adjuntancy" value="{{ $delay->employee->adjuntancy }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável*</small>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Nome</label>
                                        <input type="text" name="name" value="{{ $delay->employee->name }}" class="form-control" disabled>
                                        <small class="form-text text-muted">Campo inalterável*</small>
                                    </div>
                                </div>
                                <h4>Informações dos atrasos</h4>
                                <div id="delay_details_container">
                                    @foreach($delay->detail as $details)
                                        <div class="row mt-3 delay-group">
                                            <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                            <div class="form-group col-lg-3">
                                                <label>Data do atraso</label>
                                                <input type="date" name="detail[{{ $loop->index }}][delay_date]" value="{{ $details->delay_date }}" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Chegada</label>
                                                <input type="time" name="detail[{{ $loop->index }}][arrival]" value="{{ $details->arrival }}" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Saída</label>
                                                <input type="time" name="detail[{{ $loop->index }}][leave]" value="{{ $details->leave }}" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Motivo</label>
                                                <input type="text" name="detail[{{ $loop->index }}][description]" value="{{ $details->description }}" class="form-control" disabled>
                                                <small class="form-text text-muted">Campo inalterável *</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Botões -->
                                <div class="text-center mt-3">
                                    <button type="button">
                                        <a href="{{ route('pdf.delay',  $delay->id) }}" method="GET" class="btn btn-info text-light mr-2">
                                            <i class="fa-solid fa-print"></i> Imprimir
                                        </a>
                                    </button>
                                    
                                    <button type="button">
                                        <a href="{{ route('binder.delay.index') }}" class="btn btn-warning text-dark">
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

    <!-- Scripts -->
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>

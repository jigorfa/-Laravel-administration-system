<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edição - Ocorrências</title>
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
                        <h1>Edição de ocorrências</h1>
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
                                @if (session('success'))
                                    <div class="alert alert-success m-2" role="alert">
                                        <i class="fa-solid fa-check"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('warning'))
                                    <div class="alert alert-warning m-2" role="alert">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        {{ session('warning') }}
                                    </div>
                                @endif

                                @if (session('danger'))
                                    <div class="alert alert-danger m-2" role="alert">
                                        <i class="fa-solid fa-trash"></i>k
                                        {{ session('danger') }}
                                    </div>
                                @endif
                                <form action="{{ route('binder.occurrence.update', $occurrence->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label for="employee_code">Código</label>
                                            <input type="number" id="employee_code" name="employee_code" value="{{ $occurrence->employee->code }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="adjuntancy">Cargo</label>
                                            <input type="text" id="adjuntancy" name="adjuntancy" value="{{ $occurrence->employee->adjuntancy }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Nome</label>
                                            <input type="text" id="name" name="name" value="{{ $occurrence->employee->name }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>
                                    <h4>Informações das ocorrências</h4>
                                    <div id="occurrence_info_container">
                                        @foreach($occurrence->detail as $details)
                                            <div class="row mt-3 occurrence-group" id="occurrence-group-{{ $details->id }}">
                                                <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                                <div class="form-group col-lg-2">
                                                    <label>Data</label>
                                                    <input type="date" name="detail[{{ $loop->index }}][occurrence_date]" value="{{ $details->occurrence_date }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>Tipo da ocorrência</label>
                                                    <select id="occasion_id_{{ $loop->index }}" name="detail[{{ $loop->index }}][occasion_id]" class="form-control">
                                                        <option value="" disabled>Selecione...</option>
                                                        @foreach ($occasion as $occasions)
                                                            <option value="{{ $occasions->id }}" 
                                                                {{ $details->occasion_id == $occasions->id ? 'selected' : '' }}>
                                                                {{ $occasions->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label for="description">Descrição</label>
                                                    <input type="text" name="detail[{{ $loop->index }}][description]" value="{{ $details->description }}" placeholder="Insira uma descrição" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>Arquivo</label>
                                                    @if ($details->annex)
                                                        <!-- Link de download se houver anexo -->
                                                        <a href="{{ asset('storage/'.$details->annex) }}" class="btn btn-info btn-md form-group" target="_blank">
                                                            <i class="fa fa-download"></i> Baixar Anexo
                                                        </a>
                                                    @else
                                                        <input type="file" name="detail[{{ $loop->index }}][annex]" class="form-control mb-2">
                                                    @endif
                                                    <small class="form-text text-muted">Campo inalterável *</small>
                                                </div>
                                                <div class="form-group text-center d-flex align-items-center col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-occurrence" data-id="{{ $details->id }}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-check"></i> Atualizar
                                        </button>
                                        <button type="button" id="add_occurrence" class="btn btn-secondary">
                                            <i class="fa-solid fa-plus"></i> Atestado
                                        </button>
                                        <a href="{{ route('binder.occurrence.index') }}" class="btn btn-danger">
                                            <i class="fa-solid fa-times"></i> Cancelar
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        let rowIdx = 0;

        $('#add_occurrence').click(function () {
            rowIdx++;

            const newOccurrenceGroup = `
                <div class="row mt-3 occurrence-group" id="occurrence-group-${rowIdx}">
                    <div class="form-group col-lg-2">
                        <label>Data</label>
                        <input type="date" name="detail[${rowIdx}][occurrence_date]" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Tipo da ocorrência</label>
                        <select name="detail[${rowIdx}][occasion_id]" class="form-control" required>
                            <option value="" selected>Selecione um tipo:</option>
                            @foreach ($occasion as $occasions)
                                <option value="{{ $occasions->id }}">{{ $occasions->name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Descrição</label>
                        <input type="text" name="detail[${rowIdx}][description]" placeholder="Insira uma descrição" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Arquivo</label>
                        <input type="file" name="detail[${rowIdx}][annex]" class="form-control mb-2">
                        <small class="form-text text-muted">Campo inalterável *</small>
                    </div>
                    <div class="form-group text-center d-flex align-items-center col-lg-1">
                        <button type="button" class="btn btn-danger btn-sm remove-occurrence" data-id="${rowIdx}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;
            
            $('#occurrence_info_container').append(newOccurrenceGroup);
        });

        $(document).on('click', '.remove-occurrence', function () {
            const groupId = $(this).data('id');
            $('#occurrence-group-' + groupId).remove();
        });
    </script>
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edição - Atestados</title>
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
                        <h1>Edição de atestados</h1>
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
                                            <div class="row mt-3 occurrence-group" id="occurrence-group-{{ $details->id ?? 'new-' . $rowIdx }}">
                                                <div class="form-group col-lg-3">
                                                    <label for="occurrence_date">Data</label>
                                                    <input type="date" id="occurrence_date" name="detail[{{ $details->id ?? 'new-' . $rowIdx }}][occurrence_date]" value="{{ $details->occurrence_date }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>Tipo da ocorrência</label>
                                                    <select name="detail[{{ $details->id ?? 'new-' . $rowIdx }}][occasion_id]" class="form-control" required>
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
                                                    <input type="text" id="description" name="detail[{{ $details->id ?? 'new-' . $rowIdx }}][description]" value="{{ $details->description }}" placeholder="Insira a descrição" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="annex">Arquivo</label>
                                                    @if ($details->annex)
                                                        <a href="{{ asset('storage/'.$details->annex) }}" class="btn btn-info btn-sm" target="_blank">
                                                            <i class="fa fa-download"></i> Baixar Anexo
                                                        </a>
                                                    @else
                                                        <input type="file" id="annex" name="detail[{{ $details->id ?? 'new-' . $rowIdx }}][annex]" class="form-control mb-2">
                                                    @endif
                                                    <small class="form-text text-muted">Campo inalterável *</small>
                                                </div>
                                                <div class="form-group text-center d-flex align-items-center col-lg-1">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger btn-sm remove-occurrence" 
                                                        data-id="{{ $details->id ?? '' }}" 
                                                        data-row-id="{{ $rowIdx ?? '' }}" 
                                                        data-type="{{ isset($details->id) ? 'existing' : 'new' }}">
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
                                            <i class="fa-solid fa-plus"></i> Ocorrência
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
            const newoccurrenceGroup = `
                <div class="row mt-3 occurrence-group" id="occurrence-group-new-${rowIdx}">
                    <div class="form-group col-lg-3">
                        <label>Data</label>
                        <input type="date" name="detail[new-${rowIdx}][occurrence_date]" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Tipo da ocorrência</label>
                        <select name="detail[new-${rowIdx}][occasion_id]" class="form-control" required>
                            <option value="">Selecione um tipo:</option>
                            @foreach ($occasion as $occasions)
                                <option value="{{ $occasions->id }}">{{ $occasions->name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Descrição</label>
                        <input type="text" name="detail[new-${rowIdx}][description]" placeholder="Insira uma descrição" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Arquivo</label>
                        <input type="file" name="detail[new-${rowIdx}][annex]" class="form-control">
                        <small class="form-text text-muted">Campo inalterável *</small>
                    </div>
                    <div class="form-group text-center d-flex align-items-center col-lg-1">
                        <button type="button" class="btn btn-danger btn-sm remove-occurrence" data-type="new" data-row-id="new-${rowIdx}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#occurrence_info_container').append(newoccurrenceGroup);
        });


        $(document).on('click', '.remove-occurrence', function () {
            const button = $(this);
            const type = button.data('type');
            const id = button.data('id');
            const rowId = button.data('row-id');

            if (type === 'existing') {
                if (confirm('Tem certeza de que deseja excluir esta ocorrência?')) {
                    $(`#occurrence-group-${id}`).remove();

                    $('#occurrence_info_container').append(`
                        <input type="hidden" name="delete_existing[]" value="${id}">
                    `);
                }
            } else if (type === 'new') {
                $(`#occurrence-group-${rowId}`).remove();
            }
        });
    </script>
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>

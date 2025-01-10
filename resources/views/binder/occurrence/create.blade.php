<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Cadastro de Ocorrências">
    <meta name="author" content="Hau Nguyen">
    <title>Cadastro - Ocorrências</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url ('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body class="animsition bg-light">
    <div class="page-wrapper">
        @include('layouts.navigation')

        <div class="page-content">
            <section class="welcome p-t-10 col-md-12">
                <div>
                    <h1 class="text-center">Cadastro de ocorrências</h1>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Ops!</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->all())
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Por favor, corrija os seguintes erros:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card bg-light text-dark mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-9">
                                <form action="{{ route('binder.occurrence.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label for="employee_code">Código</label>
                                            <select id="employee_code" name="employee_code" class="form-control">
                                                <option value="" selected>Selecione um código:</option>
                                                @foreach($employee as $employees)
                                                    <option value="{{ $employees->code }}">{{ $employees->code }}</option>
                                                @endforeach
                                            </select>
                                            <small>Campo obrigatório *</small>
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label for="employee_adjuntancy">Cargo</label>
                                            <input type="text" id="employee_adjuntancy" class="form-control" readonly>
                                            <small>Campo automático *</small>
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label for="employee_name">Nome</label>
                                            <input type="text" id="employee_name" class="form-control" readonly>
                                            <small>Campo automático *</small>
                                        </div>
                                    </div>

                                    <h4>Informações das ocorrências</h4>
                                    <div id="occurrence_info_container">    
                                        <div class="occurrence-group row mt-3">
                                            <div class="form-group col-lg-2">
                                                <label>Data</label>
                                                <input type="date" name="detail[0][occurrence_date]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label>Tipo da ocorrência</label>
                                                <select name="detail[0][occasion_id]" class="form-control" required>
                                                    <option value="">Selecione um tipo:</option>
                                                    @foreach ($occasion as $occasions)
                                                        <option value="{{ $occasions->id }}">{{ $occasions->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Descrição</label>
                                                <input type="text" name="detail[0][description]" class="form-control" placeholder="Insira uma descrição" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Anexo</label>
                                                <input type="file" name="detail[0][annex]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i> Cadastrar
                                        </button>
                                        <button type="button" id="add_occurrence" class="btn btn-secondary">
                                            <i class="fa fa-plus"></i> Ocorrência
                                        </button>
                                        <a href="{{ route('binder.occurrence.index') }}" class="btn btn-danger">
                                            <i class="fa fa-times"></i> Cancelar
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

    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>

    <script>
        $('#employee_code').on('change', function() {
            var code = $(this).val();
            var url = '{{ route("binder.occurrence.getEmployeeByCode", ":code") }}';
            url = url.replace(':code', code);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        $('#employee_name').val(response.name);
                        $('#employee_adjuntancy').val(response.adjuntancy);
                    } else {
                        alert('Funcionário não encontrado.');
                        $('#employee_name').val('');
                        $('#employee_adjuntancy').val('');
                    }
                },
                error: function() {
                    alert('Erro ao buscar os dados do funcionário.');
                    $('#employee_name').val('');
                    $('#employee_adjuntancy').val('');
                }
            });
        });
    </script>

    <script>
        let rowIdx = 0;

        $('#add_occurrence').click(function () {
            rowIdx++;

            const template = $('.occurrence-group').first().clone();
            
            template.find('input').val('');
            template.find('.remove-occurrence').remove();

            template.find('input, select').each(function () {
                const input = $(this);
                const nameAttr = input.attr('name');
                const idAttr = input.attr('id');

                if (nameAttr) {
                    input.attr('name', nameAttr.replace(/\[\d+\]/, `[${rowIdx}]`));
                }

                if (idAttr) {
                    input.attr('id', idAttr.replace(/_\d+$/, `_${rowIdx}`));
                }
            });

            const buttonGroup = $('<div class="form-group col-lg-1 text-center d-flex align-items-center"></div>');
            const button = $('<button type="button" class="btn btn-danger btn-sm remove-occurrence"><i class="fa fa-trash-alt"></i></button>');
            
            buttonGroup.append(button);

            template.append(buttonGroup);
            
            $('#occurrence_info_container').append(template);
        });

        $(document).on('click', '.remove-occurrence', function () {
            $(this).closest('.occurrence-group').remove();
        });
    </script>

    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
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
    <script src="{{ url ('assets/dashboard/js/autofill.js') }}"></script>
</body>
</html>

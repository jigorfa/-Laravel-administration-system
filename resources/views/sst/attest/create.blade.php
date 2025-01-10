<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro - Atestados</title>
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
                    <h1 class="text-center">Cadastro de atestados</h1>
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
                                <form action="{{ route('sst.attest.store') }}" method="POST" enctype="multipart/form-data">
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
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="employee_adjuntancy">Cargo</label>
                                            <input type="text" id="employee_adjuntancy" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="employee_name">Nome</label>
                                            <input type="text" id="employee_name" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>
                                    <h4>Detalhes do atestado</h4>
                                    <div id="attest_info_container">
                                        <div class="row mt-3 attest-group">
                                            <div class="form-group col-lg-2">
                                                <label>Início do atestado</label>
                                                <input type="date" name="detail[0][start_attest]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label>Fim do atestado</label>
                                                <input type="date" name="detail[0][end_attest]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Causa social</label>
                                                <input type="text" name="detail[0][cause]" placeholder="Insira a causa social" class="form-control" required>
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
                                            <i class="fa-solid fa-check"></i> Cadastrar
                                        </button>
                                        <button type="button" id="add_attest" class="btn btn-secondary">
                                            <i class="fa-solid fa-plus"></i>  Atestado
                                        </button>
                                        <a href="{{ route('sst.attest.index') }}" class="btn btn-danger">
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
        $('#employee_code').on('change', function() {
            var code = $(this).val();
            var url = '{{ route("sst.attest.getEmployeeByCode", ":code") }}';
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

        $('#add_attest').click(function () {
            rowIdx++;

            const template = $('.attest-group').first().clone();
            
            template.find('input').val('');
            template.find('.remove-attest').remove();

            template.find('input').each(function () {
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
            
            const button = $('<button type="button" class="btn btn-danger btn-sm remove-attest"><i class="fa fa-trash-alt"></i></button>');
            
            buttonGroup.append(button);

            template.append(buttonGroup);
            
            $('#attest_info_container').append(template);
        });

        $(document).on('click', '.remove-attest', function () {
            $(this).closest('.attest-group').remove();
        });
    </script>

    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>
 
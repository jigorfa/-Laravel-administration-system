<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags e Títulos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro - Atraso</title>
    <!-- Estilos -->
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
                    <h1 class="text-center">Cadastro de atrasos</h1>
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
                                <form action="{{ route('binder.delay.store') }}" method="POST">
                                    @csrf
                                    <!-- Informações de Identificação -->
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label for="employee_code">Código</label>
                                            <select class="form-control" id="employee_code" name="employee_code">
                                                <option value="" selected>Selecione um código:</option>
                                                @foreach($employee as $employees)
                                                    <option value="{{ $employees->code }}">{{ $employees->code }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Campo obrigatório *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Cargo</label>
                                            <input type="text" name="adjuntancy" id="employee_adjuntancy" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Nome</label>
                                            <input type="text" name="name" id="employee_name" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>

                                    <!-- Detalhes do Atraso -->
                                    <h4>Informações dos atrasos</h4>
                                    <div id="delay_info_container">
                                        <div class="row mt-3 delay-group">
                                            <div class="form-group col-lg-3">
                                                <label>Data</label>
                                                <input type="date" name="detail[0][delay_date]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label>Chegada</label>
                                                <input type="time" name="detail[0][arrival]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label>Saída</label>
                                                <input type="time" name="detail[0][leave]" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Motivo</label>
                                                <input type="text" name="detail[0][description]" placeholder="Insira um motivo" class="form-control" required>
                                                <small class="form-text text-muted">Campo obrigatório *</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botões -->
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-check"></i> Cadastrar
                                        </button>
                                        <button type="button" id="add_delay" class="btn btn-secondary">
                                            <i class="fa-solid fa-plus"></i> Atraso
                                        </button>
                                        <a href="{{ route('binder.delay.index') }}" class="btn btn-danger">
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

    <!-- Scripts -->
    <script>
        $('#employee_code').on('change', function() {
            var code = $(this).val(); // Obtém o valor do campo Código
            var url = '{{ route("binder.delay.getEmployeeByCode", ":code") }}';
            url = url.replace(':code', code);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        // Preenche os campos automaticamente
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
        let rowIdx = 0; // Inicializa o índice das linhas

        $('#add_delay').click(function () {
            rowIdx++; // Incrementa o índice para cada novo campo

            const template = $('.delay-group').first().clone();
            
            // Limpa os campos do template clonado
            template.find('input').val('');
            template.find('.remove-delay').remove(); // Remove o botão existente, se houver

            // Atualiza os índices dos campos input
            template.find('input').each(function () {
                const input = $(this);
                const nameAttr = input.attr('name');
                const idAttr = input.attr('id');

                // Atualiza o atributo name com o novo índice
                if (nameAttr) {
                    input.attr('name', nameAttr.replace(/\[\d+\]/, `[${rowIdx}]`));
                }

                // Atualiza o atributo id com o novo índice
                if (idAttr) {
                    input.attr('id', idAttr.replace(/_\d+$/, `_${rowIdx}`));
                }
            });

            // Cria uma nova div de form-group para o botão
            const buttonGroup = $('<div class="form-group col-lg-1 text-center d-flex align-items-center"></div>');
            
            // Cria o botão de remoção
            const button = $('<button type="button" class="btn btn-danger btn-sm remove-delay"><i class="fa fa-trash-alt"></i></button>');
            
            // Adiciona o botão ao novo form-group
            buttonGroup.append(button);

            // Adiciona a nova div ao final da div .occurrence-group
            template.append(buttonGroup); // Adiciona o grupo do botão fora do form-group
            
            // Adiciona o template clonado ao container
            $('#delay_info_container').append(template);
        });

        // Função para remover a div quando o botão de remoção for clicado
        $(document).on('click', '.remove-delay', function () {
            $(this).closest('.delay-group').remove();
        });
    </script>


    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>
 
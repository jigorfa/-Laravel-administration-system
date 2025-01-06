<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags e Títulos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edição - Ocorrência</title>
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
                                        <i class="fa-solid fa-trash"></i>
                                        {{ session('danger') }}
                                    </div>
                                @endif
                                <form action="{{ route('binder.occurrence.update', $occurrence->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- Informações de Identificação -->
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label>Código</label>
                                            <input type="number" name="employee_code" value="{{ $occurrence->employee->code }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Cargo</label>
                                            <input type="text" name="adjuntancy" value="{{ $occurrence->employee->adjuntancy }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Nome</label>
                                            <input type="text" name="name" value="{{ $occurrence->employee->name }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>
                                    <!-- Detalhes do Atraso -->
                                    <h4>Informações das ocorrências</h4>
                                    <div id="occurrence_info_container">
                                        @foreach($occurrence->detail as $details)
                                            <div class="row mt-3 occurrence-group">
                                                <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                                <div class="form-group col-lg-3">
                                                    <label>Data da ocorrência</label>
                                                    <input type="date" name="detail[{{ $loop->index }}][occurrence_date]" value="{{ $details->occurrence_date }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label for="occasion_id_{{ $loop->index }}">Tipo da ocorrência</label>
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
                                                <div class="form-group col-lg-5">
                                                    <label>Descrição</label>
                                                    <input type="text" name="detail[{{ $loop->index }}][description]" value="{{ $details->description }}" placeholder="Insira uma descrição sobre a ocorrência" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group text-center d-flex align-items-center col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-occurrence" data-id="{{ $details->id }}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Botões -->
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

    <!-- Scripts -->
    <script>
        let rowIdx = document.querySelectorAll('.occurrence-group').length; 

        // Função para adicionar uma nova ocorrência
        $('#add_occurrence').click(function () {
            rowIdx++; // Incrementa o índice para cada novo campo

            // Clona o primeiro grupo de ocorrência
            const template = $('.occurrence-group').first().clone();

            // Limpa os valores do template clonado
            template.find('input, select').each(function () {
                if (this.tagName === 'SELECT') {
                    this.selectedIndex = 0; // Reseta o select para a primeira opção
                } else {
                    $(this).val(''); // Limpa o valor dos inputs
                }

                // Atualiza os atributos 'name' e 'id' para refletir o novo índice
                const nameAttr = $(this).attr('name');
                const idAttr = $(this).attr('id');
                if (nameAttr) {
                    $(this).attr('name', nameAttr.replace(/\[\d+\]/, `[${rowIdx}]`));
                }
                if (idAttr) {
                    $(this).attr('id', idAttr.replace(/_\d+$/, `_${rowIdx}`));
                }
            });

            // Marca como registro clonado
            template.addClass('cloned');

            // Ajusta o comportamento do botão de exclusão
            template.find('.remove-occurrence').off('click').on('click', function () {
                const group = $(this).closest('.occurrence-group');
                if (group.hasClass('cloned')) {
                    // Remove apenas no frontend
                    group.remove();
                }
            });

            $('#occurrence_info_container').append(template);
        });

        // Adiciona comportamento ao botão de exclusão nos registros existentes
        $(document).on('click', '.remove-occurrence', function () {
            const detailId = $(this).data('id'); // Obtém o ID do detalhe do botão
            const group = $(this).closest('.occurrence-group'); // Seleciona o grupo correspondente

            if (group.hasClass('cloned')) {
                // Apenas remove o grupo do DOM para campos clonados
                group.remove();
            } else if (detailId) {
                // Para registros existentes, cria um formulário para enviar a requisição DELETE
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST'; // O método deve ser POST
                deleteForm.action = `/occurrence/detail/${detailId}`; // Define a rota correta

                // Adiciona token CSRF
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}"; // Token CSRF do Laravel
                deleteForm.appendChild(csrfInput);

                // Adiciona o método DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                deleteForm.appendChild(methodInput);

                // Adiciona o formulário ao body e submete
                document.body.appendChild(deleteForm);
                deleteForm.submit();
            } else {
                alert('Erro: ID do detalhe não encontrado.');
            }
        });
    </script>
    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>
</body>
</html>
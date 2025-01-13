<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edição - Atrasos/Saídas</title>
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
                        <h1>Edição de atrasos e/ou saídas</h1>
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
                                <form action="{{ route('binder.delay.update', $delay->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label>Código</label>
                                            <input type="number" name="employee_code" value="{{ $delay->employee->code }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Cargo</label>
                                            <input type="text" name="adjuntancy" value="{{ $delay->employee->adjuntancy }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Nome</label>
                                            <input type="text" name="name" value="{{ $delay->employee->name }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>
                                    <h4>Informações dos atrasos e/ou saídas</h4>
                                    <div id="delay_info_container">
                                        @foreach($delay->detail as $details)
                                            <div class="row mt-3 delay-group">
                                                <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                                <div class="form-group col-lg-3">
                                                    <label>Data do atraso</label>
                                                    <input type="date" name="detail[{{ $loop->index }}][delay_date]" value="{{ $details->delay_date }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>Chegada</label>
                                                    <input type="time" name="detail[{{ $loop->index }}][arrival]" value="{{ $details->arrival }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label>Saída</label>
                                                    <input type="time" name="detail[{{ $loop->index }}][leave]" value="{{ $details->leave }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <label>Motivo</label>
                                                    <input type="text" name="detail[{{ $loop->index }}][description]" value="{{ $details->description }}" class="form-control" placeholder="Insira uma descrição do atraso">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group text-center d-flex align-items-center col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-delay" data-id="{{ $details->id }}">
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

    <script>
        let rowIdx = document.querySelectorAll('.delay-group').length; 

        $('#add_delay').click(function () {
            rowIdx++;

            const template = $('.delay-group').first().clone();

            template.find('input, select').each(function () {
                if (this.tagName === 'SELECT') {
                    this.selectedIndex = 0;
                } else {
                    $(this).val('');
                }

                const nameAttr = $(this).attr('name');
                const idAttr = $(this).attr('id');
                if (nameAttr) {
                    $(this).attr('name', nameAttr.replace(/\[\d+\]/, `[${rowIdx}]`));
                }
                if (idAttr) {
                    $(this).attr('id', idAttr.replace(/_\d+$/, `_${rowIdx}`));
                }
            });

            template.addClass('cloned');

            template.find('.remove-delay').off('click').on('click', function () {
                const group = $(this).closest('.delay-group');
                if (group.hasClass('cloned')) {
                    group.remove();
                }
            });

            $('#delay_info_container').append(template);
        });

        $(document).on('click', '.remove-delay', function () {
            const detailId = $(this).data('id');
            const group = $(this).closest('.delay-group');

            if (group.hasClass('cloned')) {
                group.remove();
            } else if (detailId) {
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = `/delay/detail/${detailId}`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                deleteForm.appendChild(csrfInput);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                deleteForm.appendChild(methodInput);

                document.body.appendChild(deleteForm);
                deleteForm.submit();
            } else {
                alert('Erro: ID do detalhe não encontrado.');
            }
        });
    </script>
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>

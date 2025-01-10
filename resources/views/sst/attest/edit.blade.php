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
                        <h4 class="mt-2">Registro: {{ $attest->employee->name }} </h4>
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
                                <form action="{{ route('sst.attest.update', $attest->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <h4>Informações de identificação</h4>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-4">
                                            <label for="employee_code">Código</label>
                                            <input type="number" id="employee_code" name="employee_code" value="{{ $attest->employee->code }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="adjuntancy">Cargo</label>
                                            <input type="text" id="adjuntancy" name="adjuntancy" value="{{ $attest->employee->adjuntancy }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">Nome</label>
                                            <input type="text" id="name" name="name" value="{{ $attest->employee->name }}" class="form-control" readonly>
                                            <small class="form-text text-muted">Campo automático *</small>
                                        </div>
                                    </div>
                                    <h4>Informações dos atestados</h4>
                                    <div id="attest_info_container">
                                        @foreach($attest->detail as $details)
                                            <div class="row mt-3 attest-group" id="attest-group-{{ $details->id }}">
                                                <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $details->id }}">
                                                <div class="form-group col-lg-3">
                                                    <label for="start_attest">Início do atestado</label>
                                                    <input type="date" id="start_attest" name="detail[{{ $loop->index }}][start_attest]" value="{{ $details->start_attest }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label for="end_attest">Fim do atestado</label>
                                                    <input type="date" id="end_attest" name="detail[{{ $loop->index }}][end_attest]" value="{{ $details->end_attest }}" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label for="cause">Causa social</label>
                                                    <input type="text" id="cause" name="detail[{{ $loop->index }}][cause]" value="{{ $details->cause }}" placeholder="Insira a causa social" class="form-control">
                                                    <small class="form-text text-muted">Campo obrigatório *</small>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="annex">Arquivo</label>
                                                    @if ($details->annex)
                                                        <!-- Link de download se houver anexo -->
                                                        <a href="{{ asset('storage/'.$details->annex) }}" class="btn btn-info btn-sm" target="_blank">
                                                            <i class="fa fa-download"></i> Baixar Anexo
                                                        </a>
                                                    @else
                                                        <input type="file" id="annex" name="detail[{{ $loop->index }}][annex]" class="form-control mb-2">
                                                    @endif
                                                    <small class="form-text text-muted">Campo inalterável *</small>
                                                </div>
                                                <div class="form-group text-center d-flex align-items-center col-lg-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-attest" data-id="{{ $details->id }}">
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
                                        <button type="button" id="add_attest" class="btn btn-secondary">
                                            <i class="fa-solid fa-plus"></i> Atestado
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
        let rowIdx = 0;

        $('#add_attest').click(function () {
            rowIdx++;

            const newAttestGroup = `
                <div class="row mt-3 attest-group" id="attest-group-${rowIdx}">
                    <div class="form-group col-lg-3">
                        <label>Início do atestado</label>
                        <input type="date" name="detail[${rowIdx}][start_attest]" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Fim do atestado</label>
                        <input type="date" name="detail[${rowIdx}][end_attest]" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Causa social</label>
                        <input type="text" name="detail[${rowIdx}][cause]" placeholder="Insira a causa social" class="form-control">
                        <small class="form-text text-muted">Campo obrigatório *</small>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Arquivo</label>
                        <input type="file" name="detail[${rowIdx}][annex]" class="form-control mb-2">
                        <small class="form-text text-muted">Campo inalterável *</small>
                    </div>
                    <div class="form-group text-center d-flex align-items-center col-lg-1">
                        <button type="button" class="btn btn-danger btn-sm remove-attest" data-id="${rowIdx}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;
            
            $('#attest_info_container').append(newAttestGroup);
        });

        $(document).on('click', '.remove-attest', function () {
            const groupId = $(this).data('id');
            $('#attest-group-' + groupId).remove();
        });
    </script>
    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
</body>
</html>

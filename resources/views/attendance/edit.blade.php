<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Edição</title>

    <!-- Fontfaces CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url ('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ url ('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url ('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ url ('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- NAVBAR DESKTOP & MOBILE-->
        @include('layouts.navigation')
        <!-- END NAVBAR DESKTOP & MOBILE-->

        <!-- PAGE CONTENT-->
        <div class="page-content">
            <section class="welcome p-t-10 col-md-12">
                <div>
                    <h1 class="text-center">Editar registro</h1>

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Ops!</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Por favor, corrija os seguintes erros:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="list-style: none; padding-left: 0;"> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="card bg-light text-dark">
                    <div class="card-body card-block">
                        <!-- Container Centralizado -->
                        <div class="d-flex justify-content-center">
                            <div class="col-md-9">
                                <form action="{{ route('attendance.update', $attendance->code )}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="code" class="form-control-label">Código</label>
                                        <input type="number" id="code" name="code" value="{{ old('code', $attendance->code) }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Nome</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $attendance->name) }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="adjuntancy" class="form-control-label">Cargo</label>
                                        <input type="text" id="adjuntancy" name="adjuntancy" value="{{ old('adjuntancy', $attendance->adjuntancy) }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="delay_date" class="form-control-label">Data</label>
                                        <input type="date" id="delay_date" name="delay_date" class="form-control" value="{{ old('delay_date', $attendance->delay_date) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="arrival" class="form-control-label">Chegada</label>
                                        <input type="time" id="arrival" name="arrival" class="form-control" value="{{ old('arrival', $attendance->arrival) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="leave" class="form-control-label">Saída</label>
                                        <input type="time" id="leave" name="leave" class="form-control" value="{{ old('leave', $attendance->leave) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="motive" class="form-control-label">Motivo</label>
                                        <input type="text" id="motive" name="motive" value="{{  old('motive',$attendance->motive) }}" class="form-control">
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-success text-dark mr-2">
                                            <i class="fa-solid fa-check"></i> Editar
                                        </button>

                                        <a href="{{ route('attendance.index') }}" class="btn btn-danger text-dark">
                                            <i class="fa-solid fa-x"></i> Cancelar
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Fim do Container Centralizado -->
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="{{ url ('assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ url ('assets/login/js/popper.js') }}"></script>
    <script src="{{ url ('assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ url ('assets/login/js/main.js') }}"></script>

    <script src="{{ url ('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url ('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
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

    <!-- Main JS-->
    <script src="{{ url ('assets/dashboard/js/main.js') }}"></script>

</body>
</html>

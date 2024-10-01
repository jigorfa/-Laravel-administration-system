<!doctype html>
<html lang="en">
<head>
    <title>Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ url('assets/login/css/style.css') }}">
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <!-- Background Image Section -->
                        <div class="img" style="background-image: url('{{ url('assets/login/images/bg.jpeg') }}"></div>

                        <!-- Register Form Section -->
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex justify-content-between mb-4">
                                <h3>Registro</h3>
                            </div>

                            <!-- Registration Form -->
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name Field -->
                                <div class="form-group mb-3">
                                    <label for="name">Nome *</label>
                                    <input id="name" type="text" name="name" class="form-control" placeholder="Digite seu nome:" required>
                                </div>

                                <!-- Email Field -->
                                <div class="form-group mb-3">
                                    <label for="email">Email *</label>
                                    <input id="email" type="email" name="email" class="form-control" placeholder="Digite seu email:" required>
                                </div>

                                <!-- Password Field -->
                                <div class="form-group mb-3">
                                    <label for="password">Senha *</label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Digite sua senha:" required>
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirme a senha *</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirme sua senha:" required>
                                </div>

                                <!-- Display Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger col-12">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Verifique os campos e tente novamente.
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Registrar</button>
                                </div>
                            </form>

                            <!-- Already Registered Link -->
                            @if (Route::has('login'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                    Já possui conta?
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="{{ url('assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/login/js/popper.js') }}"></script>
    <script src="{{ url('assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/login/js/main.js') }}"></script>
</body>
</html>

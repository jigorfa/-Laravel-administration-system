<!doctype html>
<html lang="en">
<head>
    <title>Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ url ('assets/css/style.css')}}">
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: ('{{ url('assets/images/bg.jpeg') }}">
                </div>
                <div class="login-wrap p-4 p-md-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4">Registro</h3>
                        </div>
                        <div class="w-100">
                            <p class="social-media d-flex justify-content-end">
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                            </p>
                        </div>
                    </div>
                    <x-auth-session-status  :status="session('status')" />

                    <form method="POST" action="{{ route('register') }}">
                            @csrf
                        <div class="form-group mb-3">
                            <label class="label" for="name">Nome *</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Digite seu nome" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="name">Email *</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="Digite seu nome" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <p class="label">Função *</p>
                            <input type="radio" name="usertype" value="admin">
                            <label for="admin">Administrador</label>
                            <input type="radio" name="usertype" value="user">
                            <label for="user">Usuário</label>
                            <input-error messages="$errors->get('usertype')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="password">Senha *</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="password_confirmation">Confirme a senha *</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirme sua senha" required>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Registrar</button>
                        </div>
                    </form>
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('login') }}">
                            Já possui conta?
                        </a>
                </div>
            </div>
        </div>
    </section>

    <script src="href={{ url ('assets/js/jquery.min.js') }}"></script>
    <script src="href={{ url ('assets/js/popper.js') }}"></script>
    <script src="href={{ url ('assets/js/bootstrap.min.js') }}"></script>
    <script src="href={{ url ('assets/js/main.js') }}"></script>

</body>
</html>

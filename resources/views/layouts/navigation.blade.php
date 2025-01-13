<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Título</title>
    <!-- Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <!-- JS Principal -->
    <link href="{{ asset('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
    <!-- Fim dos links -->
</head>
<body>
    <!-- navbar (Desktop) -->
    <header class="header-desktop3 d-lg-block" style="height: 68px;">
        <div class="section__content section__content--p35">
            <div class="header3-wrap">
                <div class="header__logo">
                    <a href="{{ route('dashboard') }}">
                        <img style="height: 60px;" src="{{ asset('assets/dashboard/images/icon/mt.png') }}"/>
                    </a>
                </div>
                <div class="header__navbar">
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('employee.index') }}">
                                <i class="fas fa-address-card"></i>Funcionários
                                <span class="bot-line"></span>
                            </a>
                        </li>

                        <li class="has-sub">
                            <a href="#">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                <span class="bot-line"></span>Serviços
                            </a>
                            <ul class="header3-sub-list list-unstyled">
                                <li>
                                    <a href="{{ route('services.event.index') }}">
                                        <i class="fas fa-calendar"></i>Calendário
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('services.calculator.index') }}">
                                        <i class="fas fa-calculator"></i>Cálculos
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-sub">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i>
                                <span class="bot-line"></span>Painel
                            </a>
                        </li>

                        <li class="has-sub">
                            <a href="#">
                                <i class="fas fa-copy"></i>
                                <span class="bot-line"></span>Fichários
                            </a>
                            <ul class="header3-sub-list list-unstyled">
                                <li>
                                    <a href="{{ route('binder.delay.index') }}">
                                        <i class="fas fa-user-clock"></i>Atrasos/Saídas
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('binder.occurrence.index') }}">
                                        <i class="fas fa-circle-exclamation"></i>Ocorrências
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-sub">
                            <a href="#">
                                <i class="fas fa-heart-pulse"></i>
                                <span class="bot-line"></span>Gestão SST
                            </a>
                            <ul class="header3-sub-list list-unstyled">
                                <li>
                                    <a href="{{ route('sst.attest.index') }}">
                                        <i class="fas fa-notes-medical"></i>Atestados
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sst.epi.index') }}">
                                        <i class="fas fa-helmet-safety"></i>EPI's
                                        <span class="bot-line"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="header__tool">
                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">
                            <div class="content">
                                <a class="js-acc-btn" href="#">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="{{ asset('assets/dashboard/images/icon/user.png') }}" alt="User">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{ Auth::user()->name }}</a>
                                        </h5>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('profile.edit') }}">
                                            <i class="fas fa-gear"></i>Configurações e Suporte
                                        </a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt"></i> Encerrar sessão
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Fim da navbar (Desktop) -->

    <!-- Scripts -->
    <script src="{{ asset('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <!-- JS Principal -->
    <script src="{{ asset('assets/dashboard/js/main.js') }}"></script>
    <!-- Fim dos Scripts -->
</body>
</html>

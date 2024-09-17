<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Título</title>
    <link href="{{ asset('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">

    <!-- Font Awesome 6 CSS -->
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css') }}" rel="stylesheet" media="all">

    <link href="{{ asset('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS -->
    <link href="{{ asset('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
</head>
<body>
    <!-- NAVBAR DESKTOP -->
    <header class="header-desktop3 d-none d-lg-block">
        <div class="section__content section__content--p35">
            <div class="header3-wrap">
                <div class="header__logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/dashboard/images/icon/logo-white.png') }}" alt="CoolAdmin" />
                    </a>
                </div>
                <div class="header__navbar">
                    <ul class="list-unstyled">
                        <li class="has-sub">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i>Painel
                                <span class="bot-line"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('experience.index') }}">
                                <i class="fas fa-address-card"></i>
                                <span class="bot-line"></span>Experiência
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clock.index') }}">
                                <i class="fas fa-clock"></i>
                                <span class="bot-line"></span>Atrasos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attest.index') }}">
                                <i class="fas fa-stethoscope"></i>
                                <span class="bot-line"></span>Atestados
                            </a>
                        </li>
                        <li class="has-sub">
                            <a href="{{ route('calendar.index') }}">
                                <i class="fas fa-calendar"></i>
                                <span class="bot-line"></span>Calendário
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="header__tool">
                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">
                            <div class="content">
                                <a class="js-acc-btn" href="#">
                                    <i class="fas fa-user"></i>
                                    {{ Auth::user()->name }}
                                </a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#"><img src="{{ asset('assets/dashboard/images/icon/user.png') }}" alt="User"></a>
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
                                        <a href="{{ url('/profile') }}">
                                            <i class="fas fa-gear"></i>Configurações
                                        </a>
                                    </div>

                                    <div class="account-dropdown__item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Sair') }}
                                            </x-dropdown-link>
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

    <!-- NAVBAR MOBILE -->
    <header class="header-mobile header-mobile-2 d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/dashboard/images/icon/logo-white.png') }}" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="has-sub">
                        <a class="js-arrow" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>Painel</a>
                    </li>
                    <li>
                        <a href="{{ route('experience.index') }}"><i class="fas fa-address-card"></i>Experiência</a>
                    </li>
                    <li>
                        <a href="{{ route('clock.index') }}"><i class="fas fa-clock"></i>Atrasos</a>
                    </li>
                    <li>
                        <a href="{{ route('attest.index') }}"><i class="fas fa-stethoscope"></i>Atestados</a>
                    </li>
                    <li>
                        <a href="{{ route('calendar.index') }}"><i class="fas fa-calendar"></i>Calendário</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="sub-header-mobile-2 d-block d-lg-none">
        <div class="header__tool">
            <div class="account-wrap">
                <div class="account-item account-item--style2 clearfix js-item-menu">
                    <div class="content">
                        <a class="js-acc-btn" href="#">
                            <i class="fas fa-user"></i>
                            {{ Auth::user()->name }}
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
                                <a href="{{ url('/profile') }}">
                                    <i class="fas fa-cog"></i>Configurações
                                </a>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/main.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Calendário</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ url('assets/dashboard/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/dashboard/css/theme.css') }}" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet"/>
</head>

<body class="animsition page-wrapper">

    @include('layouts.navigation')

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

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <!-- Usando a grid do Bootstrap para ajustar o tamanho do calendário -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    // Buscar os feriados da API BrasilAPI
                    fetch('https://brasilapi.com.br/api/feriados/v1/2025')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Feriados da API:', data); // Verifique o formato dos dados recebidos

                            // Verifica se a resposta contém os dados esperados
                            if (!data || !Array.isArray(data)) {
                                failureCallback('Formato de resposta inesperado');
                                return;
                            }

                            // Converte os dados dos feriados para o formato aceito pelo FullCalendar
                            var holidays = data.map(feriado => {
                                return {
                                    title: feriado.name,
                                    start: feriado.date,
                                    allDay: true,
                                    color: 'red' // Cor dos feriados
                                };
                            });

                            // Agora, buscar os eventos do backend
                            fetch("{{ route('services.event.getEvents') }}")
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Eventos do Backend:', data); // Verifique os dados do backend

                                    // Combina os feriados com os eventos do backend
                                    successCallback(holidays.concat(data));
                                })
                                .catch(error => {
                                    console.error('Error fetching backend events:', error);
                                    failureCallback(error);
                                });
                        })
                        .catch(error => {
                            console.error('Error fetching holidays:', error);
                            failureCallback(error);
                        });
                },
                dateClick: function (info) {
                    document.getElementById('start_day').value = info.dateStr;
                    document.getElementById('finish_day').value = info.dateStr;
                    const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModal.show();
                },
            });

            calendar.render();
        });
    </script>


    <script src="{{ url('assets/dashboard/vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</body>
</html>

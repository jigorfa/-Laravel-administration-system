document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        locale:"pt-br",

        headerToolbar:{
            left: 'prev next today',
            center: 'title',
            right: 'dayGridMonth timeGridWeek listWeek',
        },

        dateClick:function(info){
            $("#event").modal("show");
        },
    });

    calendar.render();
  });

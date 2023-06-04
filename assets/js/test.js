import './../styles/test.scss';

// import 'bootstrap/dist/css/bootstrap.css';
// import 'bootstrap-icons/font/bootstrap-icons.css'; // needs additional webpack config!

import {Calendar} from '@fullcalendar/core'
import rrulePlugin from '@fullcalendar/rrule'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import frLocale from '@fullcalendar/core/locales/fr';
// import bootstrap5Plugin from '@fullcalendar/bootstrap5';

let calendarEl = document.getElementById('calendar');
let calendar   = new Calendar(calendarEl, {
    plugins: [rrulePlugin, dayGridPlugin, timeGridPlugin],
    locale: frLocale,
    // themeSystem: 'bootstrap5',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    initialView: 'dayGridMonth',
    events: {
        url: '/api/events',
        method: 'POST',
    },
});
calendar.render();

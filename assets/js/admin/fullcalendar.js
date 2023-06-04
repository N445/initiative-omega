import './../../styles/admin/fullcalendar.scss';

import {Calendar} from '@fullcalendar/core'
import rrulePlugin from '@fullcalendar/rrule'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import frLocale from '@fullcalendar/core/locales/fr';

let calendarEl = document.getElementById('calendar');
let calendar   = new Calendar(calendarEl, {
    plugins: [rrulePlugin, dayGridPlugin, timeGridPlugin],
    locale: frLocale,
    weekNumbers: true,
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



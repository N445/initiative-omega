import './../styles/event.scss';

const dayjs = require('dayjs')
require('dayjs/locale/fr')
const relativeTime = require('dayjs/plugin/relativeTime')
// const duration     = require('dayjs/plugin/duration')
dayjs.extend(relativeTime)
// dayjs.extend(duration)
dayjs.locale('fr')

$('.has-rrrule').on('click', function () {
// toggle .rrule-content

    $('.rrule-content').toggle(200);
})

$(function () {
    // $('[data-duration-display]').each(function (key, element) {
    //     let nbSeconds = $(element).data('duration-display');
    //     console.log(nbSeconds);
    //     let duration = dayjs.duration(nbSeconds, 'second');
    //     console.log(duration);
    //     console.log(duration.humanize());
    //     console.log(duration.humanize(true));
    //     $(element).html(duration.humanize());
    // });

    $('[data-moment-js]').each(function (key, element) {
        $(element).html(dayjs($(element).data('moment-js')).fromNow());
    });
})

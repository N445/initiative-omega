/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import '@popperjs/core';
import {ScrollSpy} from 'bootstrap';

window.Noty = require('noty');


$(function () {
    const scrollSpy = new ScrollSpy(document.body, {
        target: '#main-navbar',
    })


    let flashContainer = $('.flash-message-wrapper');
    let flashMessages  = flashContainer.find('.flash-message');
    if(flashMessages.length > 0) {
        $.each(flashMessages, function (key, message) {
            message  = $(message);
            // alert, success, warning, error, info/information
            let type = "info";

            if(message.hasClass('alert-alert')) {
                type = "alert";
            }
            if(message.hasClass('alert-success')) {
                type = "success";
            }
            if(message.hasClass('alert-warning')) {
                type = "warning";
            }
            if(message.hasClass('alert-danger')) {
                type = "error";
            }
            if(message.hasClass('alert-error')) {
                type = "error";
            }

            new Noty({
                theme: 'mint',
                type: type,
                text: message.find('.message').html(),
                timeout: 8000 + ((key + 1) * 1000),
                queue: 'notification',
            }).show();
        });
    }

    $('.navbar-toggler').on('click', function () {
        $(this).toggleClass('is-active');
    })


    let addToCartBtn   = $('.main-btn-container');
    // let addToCartBtn = $('.main-btn-container .main-btn');
    let gradiantBefore = $('.main-btn-container::before');
    let gradiant       = $('.main-btn-container .main-btn .gradiant');

    addToCartBtn.mousemove(function (e) {
        const {
                  left: t,
                  width: n,
                  top: o,
                  height: i,
              } = e.target.getBoundingClientRect(), r = (e.clientX - t) / n * 100, s = (e.clientY - o) / i * 100;

        console.log($(this).find('.main-btn-container-back'))
        $(this).find('.main-btn-container-back').css('--mouse-x', String(r));
        $(this).find('.main-btn-container-back').css('--mouse-y', String(s));
        $(this).find('.main-btn-container-back').css('background-position', 'calc((100 - var(--mouse-x, 0)) * 1%) calc((100 - var(--mouse-y, 0)) * 1%)');

        $(this).find('.main-btn .gradiant').css('--mouse-x', String(r));
        $(this).find('.main-btn .gradiant').css('--mouse-y', String(s));
        $(this).find('.main-btn .gradiant').css('background-position', 'calc((100 - var(--mouse-x, 0)) * 1%) calc((100 - var(--mouse-y, 0)) * 1%)');
    })
})

import './styles/homepage.scss';

const dayjs = require('dayjs')
require('dayjs/locale/fr')
const relativeTime = require('dayjs/plugin/relativeTime')
dayjs.extend(relativeTime)
dayjs.locale('fr')

import simpleParallax from 'simple-parallax-js';

import {Fancybox} from "@fancyapps/ui";
import {load} from 'recaptcha-v3'

window.Noty = require('noty');
import "particles.js";
import * as data from "./particlesjs-config.json";

class Contact {
    constructor() {
        let that = this;

        that.contactFormContainer    = $('#chart-contact .contact-form');
        that.recaptchaSiteKey        = that.contactFormContainer.attr('data-recaptcha-site-key');
        that.isGoogleRecaptchaLoaded = false;

        that.recatpcha = null;
        that.contactFormContainer.find('form button[type="submit"]').on('click', function (e) {
            e.preventDefault();
            that.sendContact();
        })
    }

    sendContact() {
        let that = this;

        that.contactFormContainer.find('.loader').addClass('active');
        that.contactFormContainer.find('button[type="submit"] .text').html('Envoie en cours');

        if(that.isGoogleRecaptchaLoaded) {
            that.getRecaptchaToken();
            return false;
        }
        load(that.recaptchaSiteKey).then((recaptcha) => {
            that.recatpcha               = recaptcha;
            that.isGoogleRecaptchaLoaded = true;
            that.getRecaptchaToken();
        })
    }

    getRecaptchaToken() {
        let that = this;

        that.recatpcha.execute('contact').then((token) => {
            that.contactFormContainer.find('form').find('.recaptcha').val(token);
            that.throwFromAjax();
        })
    }

    throwFromAjax() {
        let that = this;

        $.ajax({
                url: that.contactFormContainer.find('form').attr('action'),
                method: 'POST',
                data: that.contactFormContainer.find('form').serialize(),
            })
            .done(function (response) {
                that.contactFormContainer.find('form').replaceWith(response.html);
                if(response.noty !== undefined) {
                    new Noty({
                        theme: 'mint',
                        type: response.noty.type,
                        text: response.noty.text,
                        timeout: 8000,
                        queue: 'notification',
                    }).show();
                }

                that.contactFormContainer.find('button[type="submit"]').on('click', function (e) {
                    e.preventDefault();
                    that.sendContact();
                });

                that.contactFormContainer.find('.resend-contact').on('click', function (e) {
                    e.preventDefault();
                    that.contactFormContainer.find('.loader').addClass('active');
                    that.throwGetNewFormAjax()
                });
            })
            .always(function (response) {
                that.contactFormContainer.find('.loader').removeClass('active');

                if(response.responseJSON !== undefined) {
                    new Noty({
                        theme: 'mint',
                        type: 'error',
                        text: `${response.responseJSON.class} : ${response.responseJSON.detail}`,
                        timeout: 8000,
                        queue: 'notification',
                    }).show();
                }
            })
        ;
    }

    throwGetNewFormAjax() {
        let that = this;

        $.ajax({
            url: '/contact-form-submit',
            method: 'GET',
        }).done(function (response) {
                that.contactFormContainer.find('.success-message').replaceWith(response.html);
                that.contactFormContainer.find('button[type="submit"]').on('click', function (e) {
                    e.preventDefault();
                    that.sendContact();
                });
            })
            .always(function (response) {
                that.contactFormContainer.find('.loader').removeClass('active');
            })
    }
}

$(function () {
    let activityParticle = $('#activite-particle')

    particlesJS('activite-particle', data);

    const tabEl = $('#activites-navigation-pills-tab [data-bs-toggle="pill"]')
    tabEl.on('shown.bs.tab', function (event) {

        activityParticle.detach();

        let activityContent       = $($(event.target).attr('data-bs-target'));
        let activityContentBanner = activityContent.find('.banner .content');
        activityContentBanner.append(activityParticle);
    })


    $('[data-ajax-video]').each(function (key, element) {
        if('none' === $(element).css('display')){
            return false;
        }
        let req = new XMLHttpRequest();
        req.open('GET', $(element).attr('data-ajax-video'), true);
        req.responseType = 'blob';
        req.onload       = function () {
            if(this.status === 200) {
                let videoBlob = this.response;
                let vid       = URL.createObjectURL(videoBlob);
                $(element).attr('src', vid);
            }
        }
        req.onerror      = function () {
            // Error
        }

        req.send();
    })

    $('.custom-navbar [data-to-scroll-element], .custom-navbar [data-to-scroll-element-2]').on('click', function (e) {
        e.preventDefault();
        $(this).blur();
        let elementSelector = $(this).attr('data-to-scroll-element') ? $(this).attr('data-to-scroll-element') : $(this).attr('data-to-scroll-element-2');
        toElement(elementSelector, -100);
    })

    $('.a468783877').on('click', function (e) {
        e.preventDefault();
        window.location.replace("/6331f1c78e4f54.47408393");
    })

    $('.paralax').each(function () {
        let image = $(this).find('img');
        // console.log(image);
        new simpleParallax(image[0], {
            orientation: 'up',
            scale: 1.2,
            overflow: false,
            delay: 2,
            transition: 'cubic-bezier(0,0,0,1)',
            maxTransition: 0,
        });
    })

    $('[data-moment-js]').each(function (key, element) {
        $(element).html(dayjs($(element).data('moment-js')).fromNow());
    });

    new Contact();
})

function toElement(target, offet) {
    if(undefined === offet) {
        offet = 0
    }
    let offset = $(target).offset().top + offet
    $('html, body').animate({scrollTop: offset}, 'slow');
}

// $('.gradiant-container').each(function () {
//     let gradiantContainer = $(this);
//     let gradiant          = gradiantContainer.find('.gradiant');
//
//     gradiantContainer.mousemove(function (e) {
//         const {
//                   left: t,
//                   width: n,
//                   top: o,
//                   height: i,
//               } = e.target.getBoundingClientRect(), r = (e.clientX - t) / n * 100, s = (e.clientY - o) / i * 100;
//
//         gradiant.css('--mouse-x', String(r));
//         gradiant.css('--mouse-y', String(s));
//         gradiant.css('background-position', 'calc((100 - var(--mouse-x, 0)) * 1%) calc((100 - var(--mouse-y, 0)) * 1%)');
//     })
// })

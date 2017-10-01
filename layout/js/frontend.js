/*global console, alert, prompt, confirm, $*/

$(function () {
    'use strict';
    // Hide PlaceHolder On Form Focus
    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');

    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // adding asterisk to input
    $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // show password at hover
    var passField = $('.password');
    $('.show-pass').hover(function () {
        passField.attr('type', 'text');
    }, function () {
        passField.attr('type', 'password');
    });

    //confirmation to delete the member
    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });

    // full-view option
    $('.panel-body h3').click(function () {
        $(this).next('.full-view').fadeToggle();
    });

    $('.options span').click(function () {
        $(this).addClass('active').siblings('span').removeClass('active');
        if ($(this).data('view') === 'full') {
            $('.full-view').fadeIn();
        } else {
            $('.full-view').fadeOut();
        }
    });

    $('.toggle-info').click(function () {
        $(this).next('.panel-body').fadeToggle(100);
    });

});
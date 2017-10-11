/*global console, alert, prompt, confirm, $*/

$(function () {
    'use strict';
    // select the active action
    $('.in-out span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    });
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

    //confirmation to delete the member
    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });


});
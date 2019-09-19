var smsTimer = '';

$(function () {
    smsTimer = $('.sms-timer')
            .startTimer({
                onComplete: function (element) {
                    $(element)
                            .parents('.resms-wrap')
                            .first()
                            .removeClass('text-black-50');
                }
            })
            .trigger('start');
})

function reloadCaptcha(link) {

    var form = $(link).parents('form').first();

    $(link).addClass('loading');

    $.ajax({
        type: 'GET',
        url: $(form).attr('action'),
        data: 'AJAX_RELOAD_CAPTCHA=Y',
        error: function () {
            alert('Connection error');
        },
        success: function (data) {
            var obj = JSON.parse(data);

            if (obj.CAPTCHA) {
                $(form).find('input[name=CAPTCHA]').val('');
                $(form).find('input[name=CAPTCHA_CODE]').val(obj.CAPTCHA.CAPTCHA_CODE);
                $(form).find('.captcha__img').attr('src', obj.CAPTCHA.SRC);
            }

            $(link).removeClass('loading');
        }
    });

    return false;
}

function onSubmitRegForm(form) {

    var btn = $(form).find('button[type=submit]').first();

    $(btn).attr('disabled', 'disabled');

    if ($(btn).data('loading-img'))
        $(btn).html('<img src="' + $(btn).data('loading-img') + '" />');

    ClearMessage($(form).attr('id'));

    $.ajax({
        type: 'GET',
        url: $(form).attr('action'),
        data: $(form).serialize(),
        error: function () {
            alert('Connection error');
        },
        success: function (data) {
            var obj = JSON.parse(data);

            if (obj.ERRORS)
                ShowMessage($(form).attr('id'), obj.ERRORS);

            if (obj.CAPTCHA) {
                $(form).find('input[name=CAPTCHA]').val('');
                $(form).find('input[name=CAPTCHA_CODE]').val(obj.CAPTCHA.CAPTCHA_CODE);
                $(form).find('.captcha__img').attr('src', obj.CAPTCHA.SRC);
            }

            if (obj.SMS_REG)
                showSmsConfirm(form, obj);

            if (obj.SUCCESS) {

                if (obj.REDIRECT_URL){
                    window.location.replace(obj.REDIRECT_URL);
                    return true;
                }

                $(form)
                        .find('.form-wrap')
                        .slideUp();

                ShowMessage($(form).attr('id'), obj.SUCCESS, 'SUCCESS');
            }

            $(form).find('.resend-sms').remove();
            $(btn).removeAttr('disabled');
            if ($(btn).data('loading-text'))
                $(btn).html($(btn).data('loading-text'));
        }
    });

    return false;
}

function regFormChangeNumber(link) {

    var form = $(link).parents('form').first();

    $(link).hide();
    $(form)
            .find('input[name=PERSONAL_PHONE]')
            .removeAttr('disabled');
    $(form)
            .find('input[name=SMSCODE]')
            .val('');
    $(form)
            .find('input[name=SMSCODE]')
            .parents('.form-group')
            .first()
            .slideUp();
    $(form)
            .find('input[name=CAPTCHA]')
            .val('');

    $(form)
            .find('button[type=submit]')
            .html(BX.message('FORM_SUBMIT_REG_SMS'))
            .data('loading-text', BX.message('FORM_SUBMIT_REG_SMS'));

    return false;
}

function showSmsConfirm(form, obj) {

    $(form)
            .find('input[name=PERSONAL_PHONE]')
            .attr('disabled', 'disabled');

    $(form)
            .find('.personal-phone a')
            .show();

    $(form)
            .find('input[name=SMSCODE]')
            .val('');

    $(form)
            .find('.reg-captcha')
            .slideUp();

    $(form)
            .find('input[name=SMSCODE]')
            .parents('.form-group')
            .first()
            .slideDown();

    if (obj.SMS_REG) {

        $(form)
                .find('.sms-timer')
                .data('seconds-left', obj.SMS_REG.SMS_TIME_DIFF);

        $(form)
                .find('.sms-timer')
                .parents('.resms-wrap')
                .first()
                .addClass('text-black-50');

        smsTimer.trigger('resetime');
        smsTimer.trigger('start');
    }

    $(form)
            .find('button[type=submit]')
            .html(BX.message('FORM_SUBMIT_REG'))
            .data('loading-text', BX.message('FORM_SUBMIT_REG'));
}

function reSendSms(link) {

    var form = $(link)
            .parents('form')
            .first();

    var phone = $(form)
            .find('input[name=PERSONAL_PHONE]')
            .val();

    $(form).append('<input class="resend-sms" type="hidden" name="PERSONAL_PHONE" value="' + phone + '" />');

    $(form).submit();

    return false;
}
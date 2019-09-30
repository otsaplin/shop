function onSubmitAuthForm(form) {

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
            console.log(data);
            
            var obj = JSON.parse(data);

            if (obj.ERRORS)
                ShowMessage($(form).attr('id'), obj.ERRORS);

            if (obj.CAPTCHA) {
                $(form).find('input[name=CAPTCHA]').val('');
                $(form).find('input[name=CAPTCHA_CODE]').val(obj.CAPTCHA.CAPTCHA_CODE);
                $(form).find('.captcha__img').attr('src', obj.CAPTCHA.SRC);
            }

            if (obj.SUCCESS) {

                if (obj.REDIRECT_URL) {
                    window.location.replace(obj.REDIRECT_URL);
                    return true;
                }

                $(form)
                        .find('.form-wrap')
                        .slideUp();

                $('#' + $(form).attr('id') + '__links-block').hide();

                ShowMessage($(form).attr('id'), obj.SUCCESS, 'SUCCESS');
            }

            $(btn).removeAttr('disabled');
            if ($(btn).data('loading-text'))
                $(btn).html($(btn).data('loading-text'));
        }
    });

    return false;
}

//function reloadCaptcha(link) {
//
//    var form = $(link).parents('form').first();
//
//    $(link).addClass('loading');
//
//    $.ajax({
//        type: 'GET',
//        url: $(form).attr('action'),
//        data: 'AJAX_RELOAD_CAPTCHA=Y',
//        error: function () {
//            alert('Connection error');
//        },
//        success: function (data) {
//            var obj = JSON.parse(data);
//
//            if (obj.CAPTCHA) {
//                $(form).find('input[name=CAPTCHA]').val('');
//                $(form).find('input[name=CAPTCHA_CODE]').val(obj.CAPTCHA.CAPTCHA_CODE);
//                $(form).find('.captcha__img').attr('src', obj.CAPTCHA.SRC);
//            }
//
//            $(link).removeClass('loading');
//        }
//    });
//
//    return false;
//}
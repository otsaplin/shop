$(function () {

    if ($('.phone_masked').length)
        $('.phone_masked').mask("+7 (999) 999-99-99");

})

function onSubmitForm(form) {

    var btn = $(form).find('button[type=submit]').first();

    $(btn).attr('disabled', 'disabled');

    if ($(btn).data('loading-img'))
        $(btn).html('<img src="' + $(btn).data('loading-img') + '" />');

    $(form)
            .find('.alert')
            .slideUp();

    $(form)
            .find('input, textarea')
            .removeClass('is-invalid');
}

function onSubmitFormResult(data) {

    var obj = jQuery.parseJSON(data);
    var form = $('#' + obj.FORM_ID);
    var btn = $(form).find('button[type=submit]').first();

    $(btn).removeAttr('disabled');

    if ($(btn).data('loading-text'))
        $(btn).html($(btn).data('loading-text'));

    if (obj.STR_ERRORS) {
        $(form)
                .find('.alert-danger')
                .first()
                .html(obj.STR_ERRORS)
                .slideDown();

        for (var i in obj.ERRORS) {
            $(form).find('#' + obj.ERRORS[i].ID).addClass('is-invalid');
        }
    }

    if (obj.SUCCESS) {
        $(form)
                .find('.alert-success')
                .slideDown();

        for (var q in obj.QUESTIONS) {
            $('#' + obj.QUESTIONS[q])
                    .val('')
                    .html('');
        }
    }
}
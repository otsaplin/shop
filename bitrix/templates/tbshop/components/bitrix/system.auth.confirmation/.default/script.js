function onSubmitConfirmForm(form) {

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

            if (obj.SUCCESS) {

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
function TbFormSubmit(form) {

    var btn = $(form)
            .find('button[type=submit]')
            .first();

    $(btn).attr('disabled', 'disabled');

    if ($(btn).data('loading-img'))
        $(btn).html('<img src="' + $(btn).data('loading-img') + '" />');

    ClearMessage($(form).attr('id'));

    return true;
}

function TbFormOnResponse(formId, data) {

    var obj = JSON.parse(data);
    var form = $('#' + formId);
    var btn = $(form)
            .find('button[type=submit]')
            .first();

    if (obj.ERRORS)
        ShowMessage($(form).attr('id'), obj.ERRORS);

    if (obj.SUCCESS) {
        ShowMessage($(form).attr('id'), obj.SUCCESS, 'SUCCESS');

        if (obj.ID) {
            var inpId = $(form)
                    .find('input[name=ID]')
                    .first();

            if ($(inpId).length)
                $(inpId).val(obj.ID);
            else
                $(form).append('<input type="hidden" name="ID" value="' + obj.ID + '" />');
        }

        $(form)
                .find('input[type=file]')
                .val('');

        $(form)
                .find('.DEL_FILE_PROPVALID')
                .remove();

        if (obj.FILES) {

            for (var f in obj.FILES) {

                $('#' + obj.FILES[f].ID_DOM_ELEMENT)
                        .prop("jFiler")
                        .reset();

                for (var fItem in obj.FILES[f].FILER) {
                    $('#' + obj.FILES[f].ID_DOM_ELEMENT)
                            .prop("jFiler")
                            .append(obj.FILES[f].FILER[fItem]);
                }

            }

        }
    }

    $(btn).removeAttr('disabled');
    if ($(btn).data('loading-text'))
        $(btn).html($(btn).data('loading-text'));

    return true;
}
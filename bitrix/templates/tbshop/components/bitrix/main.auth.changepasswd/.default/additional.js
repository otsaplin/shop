function ShowMessage(idForm, arMsg, type) {

    type = type || 'ERROR';

    var msgBlock = $('#' + idForm + ' .alert-danger');

    if (type === 'SUCCESS')
        msgBlock = $('#' + idForm + ' .alert-success');

    if (msgBlock.length)
        $(msgBlock).find('li').remove();

    $(arMsg).each(function () {

        if (type === 'ERROR')
            $('#' + idForm + ' [name="' + this.NAME + '"]').addClass('is-invalid');

        if (msgBlock.length && this.MESSAGE) {
            $(msgBlock).find('ul').first().append('<li>' + this.MESSAGE + '</li>');
        }
    });

    if (msgBlock.length)
        $(msgBlock).slideDown();
}

function ClearMessage(idForm) {

    var msgBlock = $('#' + idForm + ' .alert');

    if (msgBlock.length)
        $(msgBlock).slideUp();

    $('#' + idForm)
            .find('.is-invalid')
            .removeClass('is-invalid');
}
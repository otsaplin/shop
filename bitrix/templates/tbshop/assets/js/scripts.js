$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    if ($('.slider__index').length)
        $('.slider__index').slick({
            accessibility: false,
            autoplay: true,
            arrows: false,
            dots: true,
            autoplaySpeed: 5000
        });

    $('.filter-wrap .filter-block__title').on('click', function () {

        var link = $(this),
                ul = $(this)
                .parent('div')
                .find('ul')
                .first(),
                fas = $(this)
                .find('.fas')
                .first();

        $(ul).toggle('200');

        if ($(fas).hasClass('do-up'))
            $(fas).removeClass('do-up');
        else
            $(fas).addClass('do-up');

    });

    $('.filter-wrap .show_more').on('click', function () {

        $(this)
                .parents('ul')
                .first()
                .find('li.d-none')
                .removeClass('d-none');

        $(this).remove();

        return false;

    });

    $('.menu__mobile').on('click', function () {

        $(this)
                .parent('div')
                .find('.menu__list')
                .first()
                .toggleClass('active');

    });

    $('.counter .counter__plus, .counter .counter__minus, .counter input[type=text]').on('click change', function () {

        var input = $(this)
                .parents('.counter')
                .first()
                .find('input[type=text]')
                .first(),
                currentVal = parseInt(input.val());

        if (isNaN(currentVal))
            currentVal = 0;

        if ($(this).hasClass('counter__plus'))
            currentVal++;

        if ($(this).hasClass('counter__minus'))
            currentVal--;

        if (currentVal < 1)
            currentVal = 1;

        $(input).val(currentVal);

        return false;
    });

    if ($('.detail__slider').length) {

        $('.detail__slider').slick({
            asNavFor: '.detail__thumbnails',
            accessibility: false,
            arrows: false,
            infinite: false,
            adaptiveHeight: true
        });

        $('.detail__thumbnails').slick({
            asNavFor: '.detail__slider',
            accessibility: false,
            focusOnSelect: true,
            arrows: true,
            infinite: false,
            vertical: true,
            verticalSwiping: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            prevArrow: '<div class="thumbnails__arrow"><i class="fas fa-chevron-up"></i></div>',
            nextArrow: '<div class="thumbnails__arrow"><i class="fas fa-chevron-down"></i></div>',
        });

    }

    if ($('.catalog-slider').length)
        $('.catalog-slider').slick({
            accessibility: false,
            arrows: true,
            dots: false,
            infinite: false,
            slidesToShow: 4,
            prevArrow: '<div class="slider__arrow slider__arrow-prev"><i class="fas fa-chevron-left"></i></div>',
            nextArrow: '<div class="slider__arrow slider__arrow-next"><i class="fas fa-chevron-right"></i></div>',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        arrows: false
                    }
                }
            ]
        });

})

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

function addToBasket(link) {

    var itemId = $(link).data('id');
    var url = $(link).data('url');
    var quantityItem = $('input[name=quantity][data-id=' + itemId + ']');
    var cnt = 1;

    if ($(link).hasClass('disabled'))
        return false;

    if (quantityItem.length)
        cnt = $(quantityItem).val();

    $(link).addClass('disabled');

    if ($(link).data('loading-img'))
        $(link).html('<img src="' + $(link).data('loading-img') + '" />');

    $.ajax({
        type: 'GET',
        url: url,
        data: '&quantity=' + cnt,
        error: function () {
            alert('Connection error');
        },
        success: function (data) {
            //console.log(data);

            $(data).each(function () {

                if ($(this).attr('id') == 'basket-header-inner')
                    $('#basket-header-wrap').html(this);

                if ($(this).attr('id') == 'basket-modal-inner') {
                    $('#basket-modal .modal-body').html(this);
                    $('#basket-modal').modal();
                }
            });

            $(link).removeClass('disabled');

            if ($(link).data('loading-text'))
                $(link).html($(link).data('loading-text'));
        }
    });

    return false;
}
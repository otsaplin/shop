<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$class = ($arParams['LINE_ELEMENT_COUNT'] == '4') ? 'col-12 col-sm-6 col-md-4 col-lg-3' : 'col-12 col-sm-6 col-md-4';
?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <img style="display:none;" src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" />
    <div class="row catalog">
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="<?= $class; ?>">
                <div class="catalog__item">
                    <div class="catalog__hover">
                        <div class="catalog__img">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><img src="<?= $arItem['DISPLAY_PICTURE'][0]['SRC']; ?>" /></a>
                        </div>
                        <div class="catalog__price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
                        <div class="catalog__name">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><?= $arItem['NAME']; ?></a>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary btn__add-to-basket" href="#" data-id="<?= $arItem['ID']; ?>" data-url="<?= $arItem['ADD_URL']; ?>" data-loading-text="В корзину" data-loading-img="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" onClick="return addToBasket(this);">В корзину</a>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
        <? if (!empty($arResult['NAV_STRING']) && $arParams['DISPLAY_BOTTOM_PAGER'] == 'Y') echo $arResult['NAV_STRING']; ?>
    </div>
<? } else { ?>
    <p>Данный раздел пока пуст.</p>
<? } ?>
<? $this->SetViewTarget('title_counter'); ?>
<span><?= $arResult['CNT_STRING']; ?></span>
<? $this->EndViewTarget(); ?>
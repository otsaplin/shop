<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <h4 class="my-5">Вы просматривали</h4>

    <img style="display:none;" src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" />
    <div class="catalog catalog-slider">
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="catalog-slider_wrap">
                <div class="catalog__item">
                    <div class="catalog__hover">
                        <div class="catalog__img">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><img src="<?= $arItem['DISPLAY_PICTURE'][0]['SRC']; ?>" /></a>
                        </div>
                        <div class="catalog__price"><?= $arItem['MIN_PRICE']['PRINT_PRICE']; ?></div>
                        <div class="catalog__name">
                            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><?= $arItem['NAME']; ?></a>
                        </div>
                        <div class="text-center">
                            <a class="btn btn_red btn__add-to-basket" href="#" data-id="<?= $arItem['ID']; ?>" data-url="<?= $arItem['ADD_URL']; ?>" data-loading-text="В корзину" data-loading-img="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" onClick="return addToBasket(this);">В корзину</a>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
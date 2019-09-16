<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <div class="col-4 d-none d-lg-block text-center">
        <h4>Рекомендуем</h4>
        <div class="row v-catalog mt-3">
            <? foreach ($arResult['ITEMS'] as $arItem) { ?>
                <div class="col-8 offset-2">
                    <div class="v-catalog__item">
                        <div class="v-catalog__img">
                            <a href="<?=$arItem['DETAIL_PAGE_URL'];?>"><img src="<?=$arItem['DISPLAY_PICTURE'][0]['SRC'];?>" /></a>
                        </div>
                        <? if (!empty($arItem['MIN_PRICE'])) { ?>
                            <div class="v-catalog__price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
                        <? } ?>
                        <div class="v-catalog__nwrap">
                            <div class="v-catalog__name"><a href="<?= $arItem['DETAIL_PAGE_URL']; ?>"><?= $arItem['NAME']; ?></a></div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
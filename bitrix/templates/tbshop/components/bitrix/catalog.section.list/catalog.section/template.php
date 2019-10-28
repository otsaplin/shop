<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['SECTIONS'])) { ?>
    <div class="container <?=$arParams['ADDITIONAL_CLASS'];?>">
        <div class="row">
            <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 subcat__wrap">
                    <div class="row">
                        <div class="col-12 border subcat__hover">
                            <div class="row">
                                <div class="subcat__img col-3 col-md-12">
                                    <? if (!empty($arSection['DISPLAY_PICTURE'])) { ?>
                                        <a href="<?= $arSection['SECTION_PAGE_URL']; ?>">
                                            <img src="<?= $arSection['DISPLAY_PICTURE']['SRC']; ?>" style="margin-top:<? echo round((110 - $arSection['DISPLAY_PICTURE']['HEIGHT']) / 2, 0); ?>px;" />
                                        </a>
                                    <? } ?>
                                </div>
                                <div class="subcat__name col-8 col-md-12">
                                    <a href="<?= $arSection['SECTION_PAGE_URL']; ?>"><?= $arSection['NAME']; ?></a>
                                </div>
                            </div>
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
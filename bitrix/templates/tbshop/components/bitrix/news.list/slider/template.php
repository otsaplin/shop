<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <div class="slider__index">
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div>
                <? if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])) { ?>
                    <a class="item" href="<?= $arItem['PROPERTIES']['LINK']['VALUE']; ?>" <? if($arItem['PROPERTIES']['BLANK']['VALUE'] == 'Y'){ ?>target="_blank"<? } ?> style="background-image: url('<?=$arItem['DISPLAY_PICTURE']['BIG']['SRC'];?>');">
                    <? } else { ?>
                        <div class="item" style="background-image: url('<?=$arItem['DISPLAY_PICTURE']['BIG']['SRC'];?>');">
                        <? } ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="slider__index-title"><?= $arItem['NAME']; ?></div>
                                <? if (!empty($arItem['PREVIEW_TEXT'])) { ?>
                                    <div class="slider__index-dsc d-none d-lg-block"><?= $arItem['PREVIEW_TEXT']; ?></div>
                                <? } ?>
                            </div>
                            <? if (!empty($arItem['DISPLAY_PICTURE']['SMALL'])) { ?>
                                <div class="col-6 text-center">
                                    <img class="slider__index-img" src="<?= $arItem['DISPLAY_PICTURE']['SMALL']['SRC']; ?>" />
                                </div>
                            <? } ?>
                        </div>
                        <? if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])) { ?>
                    </a>
                <? } else { ?>
                </div>
            <? } ?>
        </div>
    <? } ?>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
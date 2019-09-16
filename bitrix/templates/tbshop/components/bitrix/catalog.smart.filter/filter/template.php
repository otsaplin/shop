<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <form id="CATALOG_FILTER" name="<?= $arResult["FILTER_NAME"] . "_form" ?>" method="GET" action="<?= $arResult["FORM_ACTION"]; ?>">
        <input type="hidden" name="set_filter" value="Y" />
        <? foreach ($arResult["HIDDEN"] as $arItem) { ?>
            <input type="hidden" name="<?= $arItem["CONTROL_NAME"]; ?>" id="<?= $arItem["CONTROL_ID"]; ?>" value="<?= $arItem["HTML_VALUE"]; ?>" />
        <? } ?>
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <? if ($arItem['PRICE']) continue; ?>
            <div class="filter-block mt-5">
                <div class="filter-block__title"><?= $arItem['NAME']; ?> <i class="fas <?
                    if ($arItem['DISPLAY_EXPANDED'] == 'Y')
                        echo 'fa-chevron-down';
                    else
                        echo 'fa-chevron-up';
                    ?>"></i></div>
                    <? if ($arItem['PROPERTY_TYPE'] == 'L') { ?>
                        <? if ($arItem['DISPLAY_TYPE'] == 'F') { ?>
                        <ul<? if ($arItem['DISPLAY_EXPANDED'] != 'Y') echo ' style="display:none;"'; ?>>
                            <? foreach ($arItem['VALUES'] as $arValue) { ?>
                                <li>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="<?= $arValue['CONTROL_NAME']; ?>" id="<?= $arValue['CONTROL_ID']; ?>" value="<?= $arValue['HTML_VALUE']; ?>" <? if ($arValue['CHECKED']) { ?>checked="checked"<? } ?>>
                                        <label class="form-check-label" for="<?= $arValue['CONTROL_ID']; ?>"><?= $arValue['VALUE']; ?></label>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                <? } ?>
            </div>
        <? } ?>
        <div class="mt-5 text-right">
            <a class="btn btn-md btn_border" href="<?= $arResult['SEF_DEL_FILTER_URL']; ?>">Сбросить</a>
            <button class="btn btn-md btn_red" href="<?= $arResult['FILTER_URL']; ?>">Применить</button>
        </div>
    </form>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
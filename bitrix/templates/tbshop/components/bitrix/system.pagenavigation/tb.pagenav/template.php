<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['NAV']['URL']['SOME_PAGE']) && $arResult['NAV']['PAGE_COUNT'] > 1) { ?>
    <div class="col-12 my-5">
        <ul class="pagnav">
            <li><a href="<?= $arResult["NAV"]["URL"]["FIRST_PAGE"]; ?>">&laquo;</a></li>
            <? for ($i = $arResult["NAV"]["START_PAGE"]; $i <= $arResult["NAV"]["END_PAGE"]; $i++) { ?>
                <li><a <? if ($arResult["NAV"]["PAGE_NUMBER"] == $i) { ?>class="active"<? } ?> href="<?= $arResult['NAV']['URL']['SOME_PAGE'][$i]; ?>"><?= $i; ?></a></li>
                <? } ?>
            <li><a href="<?= $arResult["NAV"]["URL"]["LAST_PAGE"]; ?>">&raquo;</a></li>
        </ul>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
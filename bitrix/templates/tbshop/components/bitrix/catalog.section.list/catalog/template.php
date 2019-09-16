<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['SECTIONS'])) { ?>
    <div class="row mt-5">
        <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
            <div class="col-12 col-lg-6">
                <div class="sections__wrap">
                    <img src="<?= $arSection['DISPLAY_PICTURE']['SRC']; ?>" />
                    <div class="sections__content">
                        <div class="sections__title"><a href="<?= $arSection['SECTION_PAGE_URL']; ?>"><?= $arSection['NAME']; ?></a></div>
                        <? if (!empty($arSection['ITEMS'])) { ?>
                            <ul>
                                <? foreach ($arSection['ITEMS'] as $arItem) { ?>
                                    <?
                                    $count = '';
                                    if ($arParams['COUNT_ELEMENTS'] == 'Y')
                                        $count = '<span>' . $arItem['ELEMENT_CNT'] . '</span>';
                                    ?>
                                    <li><a href="<?= $arItem['SECTION_PAGE_URL']; ?>"><?= $arItem['NAME']; ?><?= $count; ?></a></li>
                                <? } ?>
                            </ul>
                        <? } ?>
                    </div>
                    <div class="clearfix"></div>
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
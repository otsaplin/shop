<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if (!empty($arResult['SECTIONS'])) { ?>
    <div class="filter-block__title"><?= GetMessage('SIDEBAR_CAT_TITLE'); ?> <i class="fas fa-chevron-down"></i></div>
    <ul class="filter-block__cat">
        <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
            <?
            if ($arSection['DISPLAY'] != 'Y')
                continue;

            $class = 'filter-block__depth_' . $arSection['DEPTH_LEVEL'];
            if ($arSection['CURRENT'] == 'Y')
                $class .= ' filter-block__current';

            $count = '';
            if ($arParams['COUNT_ELEMENTS'] == 'Y')
                $count = '<span>' . $arSection['ELEMENT_CNT'] . '</span>';
            ?>
            <li class="<?= $class; ?>"><a href="<?= $arSection['SECTION_PAGE_URL']; ?>"><?= $arSection['NAME']; ?><?= $count; ?></a></li>
        <? } ?>
    </ul>
<? } ?>
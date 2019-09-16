<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <ul class="footer__link">
        <? if (!empty($arParams['TITLE'])) { ?>
            <li class="footer__title"><?= $arParams['TITLE']; ?></li>
            <? } ?>
            <? foreach ($arResult as $arItem) { ?>
            <li><a href="<?= $arItem['LINK']; ?>"><?= $arItem['TEXT']; ?></a></li>
        <? } ?>
    </ul>
<? } ?>

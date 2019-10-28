<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <ul class="left-menu">
        <? foreach ($arResult as $arItem) { ?>
            <li><a <? if ($arItem['SELECTED']) { ?>class="selected"<? } ?> href="<?= $arItem['LINK']; ?>"><?= $arItem['TEXT']; ?></a></li>
            <? } ?>
    </ul>
<? } ?>
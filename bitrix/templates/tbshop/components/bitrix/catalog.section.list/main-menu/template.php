<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult['DISPLAY_ITEMS'])) { ?>
    <div class="menu">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="menu__mobile d-md-none">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        Каталог
                    </div>
                    <ul class="menu__list">
                        <? foreach ($arResult['DISPLAY_ITEMS'] as $arSection) { ?>
                            <? if (empty($arSection['ITEMS'])) { ?>
                                <li><a href="<?= $arSection['SECTION_PAGE_URL']; ?>"><?= $arSection['NAME']; ?></a></li>
                            <? } else { ?>
                                <li>
                                    <a href="<?= $arSection['SECTION_PAGE_URL']; ?>"><?= $arSection['NAME']; ?> <i class="fas fa-chevron-down d-none d-xl-inline-block"></i></a>
                                    <div class="row menu__droplist">
                                        <? foreach ($arSection['ITEMS'] as $ar2Section) { ?>
                                            <div class="col-4 menu__dcroplist<? echo ($arParams['TOP_DEPTH'] == '3') ? ' menu__depth-3' : ''; ?>">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <? if (!empty($ar2Section['DISPLAY_PICTURE'])) { ?>
                                                            <a href="<?= $ar2Section['SECTION_PAGE_URL']; ?>">
                                                                <img src="<?= $ar2Section['DISPLAY_PICTURE']['SRC']; ?>" alt="<?= $ar2Section['NAME']; ?>" />
                                                            </a>
                                                        <? } ?>
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="mb-2">
                                                            <a href="<?= $ar2Section['SECTION_PAGE_URL']; ?>"><?= $ar2Section['NAME']; ?></a>
                                                        </div>
                                                        <? if ($arParams['TOP_DEPTH'] == '3' && !empty($ar2Section['ITEMS'])) { ?>
                                                            <div class="menu__links-3">
                                                                <? $ar2Section['ITEMS'] = array_values($ar2Section['ITEMS']); ?>
                                                                <? foreach ($ar2Section['ITEMS'] as $key => $ar3Section) { ?>
                                                                    <a href="<?= $ar3Section['SECTION_PAGE_URL']; ?>"><?= $ar3Section['NAME']; ?></a><? echo (!empty($ar2Section['ITEMS'][$key + 1])) ? ', ' : ''; ?>
                                                                <? } ?>
                                                            </div>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </li>
                            <? } ?>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult['DISPLAY_ITEMS']);
//echo '</pre>';
?>
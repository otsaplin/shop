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
                                            <div class="col-3 menu__dcroplist">
                                                <? if(!empty($ar2Section['DISPLAY_PICTURE'])){ ?>
                                                    <img src="<?=$ar2Section['DISPLAY_PICTURE']['SRC'];?>" alt="<?=$ar2Section['NAME'];?>" />
                                                <? } ?>
                                                <a href="<?=$ar2Section['SECTION_PAGE_URL'];?>"><?=$ar2Section['NAME'];?></a>
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
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
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
//print_r($arResult);
//echo '</pre>';
?>
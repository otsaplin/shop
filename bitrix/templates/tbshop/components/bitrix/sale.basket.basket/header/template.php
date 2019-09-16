<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<div id="basket-header-inner" class="row">
    <div class="col-6">
        <a class="header__info" href="/favorites/">
            <ul>
                <li><i class="far fa-heart"></i> <?= $arResult['FAVS_CNT']; ?></li>
                <li>избранное</li>
            </ul>
        </a>
    </div>
    <div class="col-6">
        <a class="header__info" href="/basket/">
            <ul>
                <li><i class="fas fa-shopping-cart"></i> <?= $arResult['BASKET_CNT']; ?></li>
                <li>корзина</li>
            </ul>
        </a>
    </div>
</div>
<? if (!empty($arResult['ADDED_ITEM'])) { ?>
    <div id="basket-modal-inner" class="row">
        <div class="col-3">
            <img src="<?= $arResult['ADDED_ITEM']['DISPLAY_PICTURE'][0]['SRC']; ?>" />
        </div>
        <div class="col-5 pt-3">
            <?= $arResult['ADDED_ITEM']['NAME']; ?>
        </div>
        <div class="col-4 pt-3 text-center">
            <?= $arResult['ADDED_ITEM']['DISPLAY_PRICE']; ?>
        </div>
    </div>
<? } ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
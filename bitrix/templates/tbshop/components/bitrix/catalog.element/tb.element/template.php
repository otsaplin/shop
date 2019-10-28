<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arParams['PROPERTY_ARTICLE'] = !empty($arParams['PROPERTY_ARTICLE']) ? $arParams['PROPERTY_ARTICLE'] : 'ARTICLE';
?>
<div class="row mt-3">
    <? if (!empty($arResult['DISPLAY_IMAGES'])) { ?>
        <div class="col-12 col-md-7">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="detail__slider">
                        <? foreach ($arResult['DISPLAY_IMAGES'] as $arImg) { ?>
                            <div>
                                <img src="<?= $arImg['BIG']['SRC']; ?>" />
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="col-3 d-none d-lg-block">
                    <div class="detail__thumbnails">
                        <? foreach ($arResult['DISPLAY_IMAGES'] as $arImg) { ?>
                            <div>
                                <div class="thumbnails__item">
                                    <div style="background-image: url('<?= $arImg['PREVIEW']['SRC']; ?>');"></div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
    <div class="col-12 col-md-5 mt-5 mt-md-0">
        <div class="row">
            <div class="col-6">
                <ul class="rating">
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li>5</li>
                </ul>
            </div>
            <? if (!empty($arResult['PROPERTIES'][$arParams['PROPERTY_ARTICLE']]['VALUE'])) { ?>
                <div class="col-6 text-right detail__article">Артикул: <?= $arResult['PROPERTIES'][$arParams['PROPERTY_ARTICLE']]['VALUE']; ?></div>
            <? } ?>
        </div>
        <? if (!empty($arResult['PREVIEW_TEXT'])) { ?>
            <div class="detail__preview-txt"><?= $arResult['PREVIEW_TEXT']; ?></div>
        <? } ?>
        <hr class="my-4">
        <? if (!empty($arResult['MIN_PRICE'])) { ?>
            <div class="detail__price"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
        <? } ?>
        <? if ($arResult['MIN_PRICE']['CAN_BUY'] == 'Y') { ?>
            <div class="detail__add mt-4">
                <ul class="counter float-left mr-3">
                    <li><a class="counter__minus" href="#"><i class="fas fa-minus"></i></a></li>
                    <li><input type="text" name="quantity" data-id="<?=$arResult['ID'];?>" class="form-control" value="1" /></li>
                    <li><a class="counter__plus" href="#"><i class="fas fa-plus"></i></a></li>
                </ul>
                <img style="display:none;" src="<?=SITE_TEMPLATE_PATH;?>/assets/img/loading_btn.gif" />
                <a class="btn btn-primary btn-lg" href="#" data-id="<?=$arResult['ID'];?>" data-url="<?=$arResult['ADD_URL'];?>" data-loading-text="В корзину" data-loading-img="<?=SITE_TEMPLATE_PATH;?>/assets/img/loading_btn.gif" onClick="return addToBasket(this);">В корзину</a>
            </div>
        <? } else { ?>
            <p>Нет в наличии</p>
        <? } ?>
        <? if (!empty($arResult['DISPLAY_PROPERTIES'])) { ?>
            <h4 class="mt-5">Основные характеристики</h4>
            <table class="props mt-4">
                <?
                $i = 1;
                foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp) {
                    if ($i > 5)
                        break;
                    ?>
                    <tr>
                        <td>
                            <div class="props__name">
                                <span><?= $arProp['NAME']; ?></span>
                            </div>
                        </td>
                        <td><?= $arProp['VALUE']; ?></td>
                    </tr>
                    <? $i++; ?>
                <? } ?>
            </table>
            <? if (count($arResult['DISPLAY_PROPERTIES']) > 5) { ?>
                <div class="mt-4">
                    <a class="a_yellow" href="#properties">все характеристики <i class="fas fa-chevron-right font-71"></i></a>
                </div>
            <? } ?>
        <? } ?>
    </div>
</div>
<div class="row mt-5">
    <? if (!empty($arResult['DETAIL_TEXT']) || !empty($arResult['DISPLAY_PROPERTIES'])) { ?>
        <div class="col-12 col-lg-8">
            <? if (!empty($arResult['DETAIL_TEXT'])) { ?>
                <h4 class="mb-4">Детальное описание</h4>
                <?= $arResult['DETAIL_TEXT']; ?>
            <? } ?>
            <? if (!empty($arResult['DISPLAY_PROPERTIES'])) { ?>
                <h4 id="properties" class="mt-5">Характеристики</h4>
                <table class="props mt-4">
                    <? foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp) { ?>
                        <tr>
                            <td>
                                <div class="props__name">
                                    <span><?= $arProp['NAME']; ?></span>
                                </div>
                            </td>
                            <td><?= $arProp['VALUE']; ?></td>
                        </tr>
                    <? } ?>
                </table>
            <? } ?>
        </div>
    <? } ?>
    <? //$APPLICATION->ShowViewContent('RECOMMEND_ITEMS'); ?>
</div>
<? $this->SetViewTarget('TITLE_ELEMENT'); ?>
<?= $arResult['NAME']; ?>
<? $this->EndViewTarget(); ?>
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
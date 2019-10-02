<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\Bitrix\Main\Loader::includeModule('tb.shop');

foreach ($arResult['ITEMS'] as &$arItem) {

    // min price
    $arMinPrice = [];

    foreach ($arItem['OFFERS'] as $arOffer) {

        if (empty($arMinPrice) || $arMinPrice['DISCOUNT_VALUE'] > $arOffer['MIN_PRICE']['DISCOUNT_VALUE'])
            $arMinPrice = $arOffer['MIN_PRICE'];
    }

    // min price
    if (empty($arItem['MIN_PRICE']) && !empty($arMinPrice))
        $arItem['MIN_PRICE'] = $arMinPrice;

    // images
    $arImgs = [];

    if (!empty($arItem['PREVIEW_PICTURE']) && count($arImgs) < 2)
        $arImgs[] = $arItem['PREVIEW_PICTURE'];

    if (!empty($arItem['DETAIL_PICTURE']) && count($arImgs) < 2)
        $arImgs[] = $arItem['DETAIL_PICTURE'];

    if (!empty($arItem['PROPERTIES']['SYSTEM_IMAGES']['VALUE']) && count($arImgs) < 2)
        foreach ($arItem['PROPERTIES']['SYSTEM_IMAGES']['VALUE'] as $val)
            $arImgs[] = array_merge($arImgs, ['ID' => $val]);

    foreach ($arImgs as $arVal) {
        $tmpImg = \CFile::ResizeImageGet($arVal['ID'], ['width' => '400', 'height' => '400'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        $arItem['DISPLAY_PICTURE'][] = [
            'WIDTH' => $tmpImg['width'],
            'HEIGHT' => $tmpImg['height'],
            'SRC' => $tmpImg['src'],
        ];
    }

    if (empty($arItem['DISPLAY_PICTURE']))
        $arItem['DISPLAY_PICTURE'][] = [
            'WIDTH' => '624',
            'HEIGHT' => '624',
            'SRC' => SITE_TEMPLATE_PATH . '/assets/img/nopic.png',
        ];
}

// Items cnt
$arResult['CNT_STRING'] = $arResult['NAV_RESULT']->NavRecordCount . ' ' . \Tb\Shop\Main::pluralForm($arResult['NAV_RESULT']->NavRecordCount, ['товар', 'товара', 'товаров']);

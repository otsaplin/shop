<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\Bitrix\Main\Loader::includeModule('tb.shop');

foreach ($arResult['ITEMS'] as &$arItem) {

    // min price
    $arMinPrice = [];

    foreach ($arItem['ITEM_PRICES'] as $arPrice)
        if (empty($arMinPrice) || $arMinPrice['PRICE'] > $arPrice['PRICE'])
            $arMinPrice = $arPrice;

    foreach ($arItem['OFFERS'] as $arOffer) {

        foreach ($arOffer['ITEM_PRICES'] as $arPrice)
            if (empty($arMinPrice) || $arMinPrice['PRICE'] > $arPrice['PRICE'])
                $arMinPrice = $arPrice;
    }

    if (empty($arItem['MIN_PRICE']) && !empty($arMinPrice))
        $arItem['MIN_PRICE'] = $arMinPrice;

    // images
    $arImgs = [];

    if (!empty($arItem['PREVIEW_PICTURE']['ID']) && count($arImgs) < 2)
        $arImgs[] = $arItem['PREVIEW_PICTURE']['ID'];

    if (!empty($arItem['DETAIL_PICTURE']['ID']) && count($arImgs) < 2)
        $arImgs[] = $arItem['DETAIL_PICTURE']['ID'];

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

    // add url
    if (empty($arItem['ADD_URL']))
        $arItem['ADD_URL'] = $arItem['DETAIL_PAGE_URL'] . '?action=ADD2BASKET&id=' . $arItem['ID'];

    // max name lenth
    if (!empty($arParams['MAX_NAME_LENGTH']) && strlen($arItem['NAME']) > $arParams['MAX_NAME_LENGTH']) {
        $tmpFirst = substr($arItem['NAME'], 0, $arParams['MAX_NAME_LENGTH']);
        $tmpSecond = substr($arItem['NAME'], $arParams['MAX_NAME_LENGTH']);

        $arItem['NAME'] = $tmpFirst . '<span class="catalog__points-name">...</span><span class="catalog__hidden-name">' . $tmpSecond . '</span>';
    }
}

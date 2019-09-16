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
        $arImgs[] = array_merge($arImgs, $arItem['PROPERTIES']['SYSTEM_IMAGES']['VALUE']);

    if (!empty($arImgs))
        foreach ($arImgs as $val) {
            $tmpImg = \CFile::ResizeImageGet($val, ['width' => '400', 'height' => '400'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
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
}

<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\Bitrix\Main\Loader::includeModule('iblock');

//$arFavsIds = \Wl\Norveg\Main::getFavs();
$arFavsIds = [];
$arResult['FAVS_CNT'] = count($arFavsIds);
$arResult['BASKET_CNT'] = 0;

foreach ($arResult['ITEMS']['AnDelCanBuy'] as &$arItem) {

    $arResult['BASKET_CNT'] += $arItem['QUANTITY'];
}

unset($arItem);

// added item
if (!empty($arParams['ADDED_ITEM'])) {
    $arItem = \CIBlockElement::GetList([], ['ID' => $arParams['ADDED_ITEM']], false, false, ['ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'])->fetch();

    if ($arItem) {

        // images
        $arImgs = [];

        if (!empty($arItem['PREVIEW_PICTURE']) && count($arImgs) < 2)
            $arImgs[] = $arItem['PREVIEW_PICTURE'];

        if (!empty($arItem['DETAIL_PICTURE']) && count($arImgs) < 2)
            $arImgs[] = $arItem['DETAIL_PICTURE'];

        if (!empty($arImgs))
            foreach ($arImgs as $val) {
                $tmpImg = \CFile::ResizeImageGet($val, ['width' => '100', 'height' => '100'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
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

        // price
        foreach ($arResult['ITEMS']['AnDelCanBuy'] as $arBasketItem)
            if ($arBasketItem['PRODUCT_ID'] == $arItem['ID']) {
                $arItem['DISPLAY_PRICE'] = $arBasketItem['PRICE_FORMATED'];
                break;
            }

        $arResult['ADDED_ITEM'] = $arItem;
    }
}
<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\Bitrix\Main\Loader::includeModule('iblock');

$cp = $this->__component;

// Images
$arImages = [];

if (!empty($arResult['PREVIEW_PICTURE']))
    $arImages[] = $arResult['PREVIEW_PICTURE'];

if (!empty($arResult['DETAIL_PICTURE']))
    $arImages[] = $arResult['DETAIL_PICTURE'];

if (!empty($arResult['PROPERTIES']['SYSTEM_IMAGES']['VALUE']))
    $arImages = array_merge($arImages, $arResult['PROPERTIES']['SYSTEM_IMAGES']['VALUE']);

foreach ($arImages as $arImg) {
    $arImgPreview = \CFile::ResizeImageGet($arImg, ['width' => '150', 'height' => '150'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
    $arImgBig = \CFile::ResizeImageGet($arImg, ['width' => '600', 'height' => '900'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
    $arResult['DISPLAY_IMAGES'][] = [
        'PREVIEW' => [
            'WIDTH' => $arImgPreview['width'],
            'HEIGHT' => $arImgPreview['height'],
            'SRC' => $arImgPreview['src']
        ],
        'BIG' => [
            'WIDTH' => $arImgBig['width'],
            'HEIGHT' => $arImgBig['height'],
            'SRC' => $arImgBig['src'],
        ],
    ];
}

if (empty($arResult['DISPLAY_IMAGES'])) {
    $arResult['DISPLAY_IMAGES'][] = [
        'PREVIEW' => [
            'WIDTH' => '150',
            'HEIGHT' => '150',
            'SRC' => SITE_TEMPLATE_PATH . '/assets/img/nopic.png',
        ],
        'BIG' => [
            'WIDTH' => '600',
            'HEIGHT' => '900',
            'SRC' => SITE_TEMPLATE_PATH . '/assets/img/nopic.png',
        ],
    ];
}
// END Images

if (!empty($arResult['PROPERTIES']['SYSTEM_RECOMMEND_ITEMS']['VALUE']))
    $cp->arResult['SYSTEM_RECOMMEND_ITEMS'] = $arResult['PROPERTIES']['SYSTEM_RECOMMEND_ITEMS'];

$cp->SetResultCacheKeys(['SYSTEM_RECOMMEND_ITEMS']);

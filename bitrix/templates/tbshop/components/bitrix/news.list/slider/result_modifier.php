<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

foreach ($arResult['ITEMS'] as &$arItem) {
    
    if(!empty($arItem['PREVIEW_PICTURE'])){
        $tmpImg = \CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], ['width' => '260', 'height' => '260'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        $arItem['DISPLAY_PICTURE']['SMALL'] = [
            'WIDTH' => $tmpImg['width'],
            'HEIGHT' => $tmpImg['height'],
            'SRC' => $tmpImg['src']
        ];
    }
    
    if(!empty($arItem['DETAIL_PICTURE'])){
        $tmpImg = \CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], ['width' => '1400', 'height' => '600'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        $arItem['DISPLAY_PICTURE']['BIG'] = [
            'WIDTH' => $tmpImg['width'],
            'HEIGHT' => $tmpImg['height'],
            'SRC' => $tmpImg['src']
        ];
    }
}
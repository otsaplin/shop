<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

foreach ($arResult['SECTIONS'] as &$arSection) {

    if (!empty($arSection['PICTURE'])) {
        $tmpImg = \CFile::ResizeImageGet($arSection['PICTURE'], ['width' => '110', 'height' => '110'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        $arSection['DISPLAY_PICTURE'] = [
            'WIDTH' => $tmpImg['width'],
            'HEIGHT' => $tmpImg['height'],
            'SRC' => $tmpImg['src']
        ];
    } else {
        $arSection['DISPLAY_PICTURE'] = [
            'WIDTH' => '110',
            'HEIGHT' => '110',
            'SRC' => SITE_TEMPLATE_PATH . '/assets/img/nopic.png'
        ];
    }
    
    // max name lenth
    if (strlen($arSection['NAME']) > 32) {
        $tmpFirst = substr($arSection['NAME'], 0, 32);
        $tmpSecond = substr($arSection['NAME'], 32);
        
        $arSection['NAME'] = $tmpFirst . '<span class="subcat__points-name">...</span><span class="subcat__hidden-name">' . $tmpSecond . '</span>';
    }
}
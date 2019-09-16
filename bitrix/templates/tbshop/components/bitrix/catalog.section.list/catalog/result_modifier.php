<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arSections = [];

foreach ($arResult['SECTIONS'] as $key => $arSection) {
    if ($arSection['DEPTH_LEVEL'] == '1') {
        
        if(!empty($arSection['PICTURE'])){
            $arTmp = \CFile::ResizeImageGet($arSection['PICTURE'], ['width' => '130', 'height' => '130'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            $arSection['DISPLAY_PICTURE'] = [
                'WIDTH' => $arTmp['width'],
                'HEIGHT' => $arTmp['height'],
                'SRC' => $arTmp['src'],
            ];
        } else {
            $arSection['DISPLAY_PICTURE'] = [
                'WIDTH' => '130',
                'HEIGHT' => '130',
                'SRC' => SITE_TEMPLATE_PATH . '/assets/img/nopic.png',
            ];
        }
        
        $arSections[] = $arSection;
    }

    if ($arSection['DEPTH_LEVEL'] == '2')
        foreach ($arSections as $tKey => $arTmpSection)
            if ($arSection['IBLOCK_SECTION_ID'] == $arTmpSection['ID'])
                $arSections[$tKey]['ITEMS'][] = $arSection;
}

$arResult['SECTIONS'] = $arSections;

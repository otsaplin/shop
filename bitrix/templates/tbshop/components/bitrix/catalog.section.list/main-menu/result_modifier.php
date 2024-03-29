<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arResult['DISPLAY_ITEMS'] = [];

// from menu file
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.main.menu.php'))
    require_once $_SERVER['DOCUMENT_ROOT'] . '/.main.menu.php';

foreach ($aMenuLinks as $mLink) {

    if (!empty($mLink[3]['ICON']))
        $mLink[0] = $mLink[3]['ICON'] . ' ' . $mLink[0];

    if ($mLink[3]['STRONG'] == 'Y')
        $mLink[0] = '<strong>' . $mLink[0] . '</strong>';

    $arResult['DISPLAY_ITEMS'][] = [
        'NAME' => $mLink[0],
        'SECTION_PAGE_URL' => $mLink[1],
    ];
}

// from catalog
foreach ($arResult['SECTIONS'] as $arSection) {

    if (!empty($arSection['PICTURE'])) {
        $tmpImg = \CFile::ResizeImageGet($arSection['PICTURE'], ['width' => '100', 'height' => '100'], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        $arSection['DISPLAY_PICTURE'] = [
            'WIDTH' => $tmpImg['width'],
            'HEIGHT' => $tmpImg['height'],
            'SRC' => $tmpImg['src']
        ];
    }

    switch ($arSection['DEPTH_LEVEL']) {

        case '1':
            $arResult['DISPLAY_ITEMS'][$arSection['ID']] = $arSection;
            break;

        case '2':

            if (array_key_exists($arSection['IBLOCK_SECTION_ID'], $arResult['DISPLAY_ITEMS']))
                $arResult['DISPLAY_ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS'][$arSection['ID']] = $arSection;

            break;

        case '3':

            foreach ($arResult['DISPLAY_ITEMS'] as &$ar1Section) {
                if (array_key_exists($arSection['IBLOCK_SECTION_ID'], $ar1Section['ITEMS']))
                    if (count($ar1Section['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS']) < 4)
                        $ar1Section['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS'][$arSection['ID']] = $arSection;
                    elseif(count($ar1Section['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS']) < 5){
                        $ar1Section['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS'][] = [
                            'NAME' => GetMessage('MORE'),
                            'SECTION_PAGE_URL' => $ar1Section['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['SECTION_PAGE_URL'],
                        ];
                    }
            }
            unset($ar1Section);

            break;
    }
}
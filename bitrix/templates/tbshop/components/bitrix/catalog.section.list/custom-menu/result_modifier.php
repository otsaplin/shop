<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arResult['DISPLAY_ITEMS'] = [];

foreach ($arResult['SECTIONS'] as $arSection) {
    $arSection['IS_SECTION'] = 'Y';
    $arSection['DISPLAY_LINK'] = $arSection['UF_LINK'];

    if ($arSection['DEPTH_LEVEL'] == '1') {
        $arResult['DISPLAY_ITEMS'][] = $arSection;
        continue;
    }
}
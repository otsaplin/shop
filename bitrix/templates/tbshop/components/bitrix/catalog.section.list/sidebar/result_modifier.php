<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arCurrent = [];
foreach ($arResult['SECTIONS'] as $key => $arSection) {
    if ($arSection['ID'] == $arParams['CURRENT_SECTION_ID'] || (!empty($arSection['CODE']) && $arSection['CODE'] == $arParams['CURRENT_SECTION_CODE'])) {
        $arCurrent = $arSection;
        $arResult['SECTIONS'][$key]['CURRENT'] = 'Y';
    }

    if ($arSection['DEPTH_LEVEL'] == '1')
        $arResult['SECTIONS'][$key]['DISPLAY'] = 'Y';
}

// the first parent of current item
$arParent = [];
if (!empty($arCurrent))
    if ($arCurrent['DEPTH_LEVEL'] == '1')
        $arParent = $arCurrent;
    else
        foreach ($arResult['SECTIONS'] as $key => $arSection) {
            if ($arSection['DEPTH_LEVEL'] == 1 && $arSection['LEFT_MARGIN'] < $arCurrent['LEFT_MARGIN'] && $arSection['RIGHT_MARGIN'] > $arCurrent['RIGHT_MARGIN']) {
                $arParent = $arSection;
            }
        }

// children of parent
if (!empty($arParent))
    foreach ($arResult['SECTIONS'] as $key => $arSection) {
        if ($arSection['LEFT_MARGIN'] > $arParent['LEFT_MARGIN'] && $arSection['RIGHT_MARGIN'] < $arParent['RIGHT_MARGIN'] && abs($arCurrent['DEPTH_LEVEL'] - $arSection['DEPTH_LEVEL']) <= 1)
            $arResult['SECTIONS'][$key]['DISPLAY'] = 'Y';

        if ($arCurrent['DEPTH_LEVEL'] < $arSection['DEPTH_LEVEL'] && ($arSection['LEFT_MARGIN'] < $arCurrent['LEFT_MARGIN'] || $arSection['RIGHT_MARGIN'] > $arCurrent['RIGHT_MARGIN']))
            $arResult['SECTIONS'][$key]['DISPLAY'] = 'N';
        
        if($arCurrent['DEPTH_LEVEL'] == $arSection['DEPTH_LEVEL'] && $arCurrent['IBLOCK_SECTION_ID'] != $arSection['IBLOCK_SECTION_ID'])
            $arResult['SECTIONS'][$key]['DISPLAY'] = 'N';
    }
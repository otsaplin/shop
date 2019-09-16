<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $APPLICATION;

if($arParams['ADD_MASKEDINPUT'] == 'Y'){
    $asset = \Bitrix\Main\Page\Asset::getInstance();
    $asset->addJs($templateFolder . '/jquery.maskedinput.js');
}

if ($arResult['isFormErrors'] == 'Y') {
    
    $arJson['FORM_ID'] = $arResult['arForm']['SID'];
    
    if (is_array($arResult['FORM_ERRORS'])) {
        $arJson['STR_ERRORS'] = implode('<br/>', $arResult['FORM_ERRORS']);

        foreach ($arResult['FORM_ERRORS'] as $key => $val)
            $arJson['ERRORS'][] = [
                'ID' => $key,
                'MESSAGE' => $val
            ];
    } else
        $arJson['STR_ERRORS'] = $arResult['FORM_ERRORS'];

    $APPLICATION->RestartBuffer();
    $strRes = '<script>';
    $strRes .= 'window.parent.onSubmitFormResult(\'' . Bitrix\Main\Web\Json::encode($arJson) . '\');';
    $strRes .= '</script>';
    die($strRes);
}

if ($_REQUEST['WEB_FORM_ID'] == $arResult['arForm']['ID'] && !empty($_REQUEST['RESULT_ID']) && $_REQUEST['formresult'] == 'addok') {

    $arQuestions = array_column($arResult['arQuestions'], 'SID');
    
    $arJson = [
        'FORM_ID' => $arResult['arForm']['SID'],
        'QUESTIONS' => $arQuestions,
        'SUCCESS' => 'Y'
    ];

    $APPLICATION->RestartBuffer();
    $strRes = '<script>';
    $strRes .= 'window.parent.onSubmitFormResult(\'' . Bitrix\Main\Web\Json::encode($arJson) . '\');';
    $strRes .= '</script>';
    die($strRes);
}
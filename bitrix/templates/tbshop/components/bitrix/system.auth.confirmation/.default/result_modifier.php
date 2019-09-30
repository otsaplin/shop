<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Web\Json;

global $APPLICATION;

if (!empty($_REQUEST['CONFIRM_FORM'])) {
    $arJsResult = [];

    if (in_array($arResult['MESSAGE_CODE'], ['E02', 'E03', 'E06'])) {
        $arJsResult = [
            'SUCCESS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arResult['MESSAGE_TEXT']
                ],
            ],
            'USER_ID' => $arResult['USER_ID'],
        ];
    } else {
        $arJsResult = [
            'ERRORS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arResult['MESSAGE_TEXT']
                ],
            ],
        ];
    }

    $APPLICATION->RestartBuffer();
    die(Json::encode($arJsResult));
}
<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Localization\Loc;

global $APPLICATION;
global $USER;

Loc::loadMessages(__FILE__);

$arParams['SUCCESS_MESSAGE'] = !empty($arParams['SUCCESS_MESSAGE']) ? $arParams['SUCCESS_MESSAGE'] : Loc::getMessage('SUCCESS_MESSAGE');

if (!empty($_REQUEST[$arResult['FIELDS']['action']])) {
    $arJsResult = [];

    if (!empty($arResult['ERRORS']))
        $arJsResult = [
            'ERRORS' => [
                0 => [
                    'NAME' => $arResult['FIELDS']['login'],
                    'MESSAGE' => strip_tags(implode(' ', $arResult['ERRORS'])),
                ],
            ],
        ];

    if ($USER->isAuthorized())
        $arJsResult = [
            'SUCCESS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arParams['SUCCESS_MESSAGE']
                ],
            ],
            'USER_ID' => $USER->getID(),
            'REDIRECT_URL' => !empty($arParams['REDIRECT_URL']) ? $arParams['REDIRECT_URL'] : '',
        ];

    $APPLICATION->RestartBuffer();
    die(Json::encode($arJsResult));
}
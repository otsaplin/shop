<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Web\Json;

global $APPLICATION;

// reload captcha
if (!empty($_REQUEST['AJAX_RELOAD_CAPTCHA'])) {
    $APPLICATION->RestartBuffer();

    $arJsResult = [
        'CAPTCHA' => [
            'CAPTCHA_CODE' => $arResult['CAPTCHA_CODE'],
            'SRC' => '/bitrix/tools/captcha.php?captcha_sid=' . $arResult['CAPTCHA_CODE'],
        ],
    ];

    die(Json::encode($arJsResult));
}

// form is submitted
if (!empty($_REQUEST[$arResult['FIELDS']['action']])) {
    $arJsResult = [];

    if (!empty($arResult['ERRORS'])) {

        $arJsResult = [
            'ERRORS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => implode(' ', $arResult['ERRORS'])
                ],
            ],
        ];

        $arJsResult['CAPTCHA'] = [
            'CAPTCHA_CODE' => $arResult['CAPTCHA_CODE'],
            'SRC' => '/bitrix/tools/captcha.php?captcha_sid=' . $arResult['CAPTCHA_CODE'],
        ];
    } else if (!empty($arResult['SUCCESS'])) {
        $arJsResult = [
            'SUCCESS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arResult['SUCCESS']
                ],
            ]
        ];
    }

    $APPLICATION->RestartBuffer();
    die(Json::encode($arJsResult));
}
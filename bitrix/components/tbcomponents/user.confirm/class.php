<?php

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class TbUserRegistrationComponent extends CBitrixComponent
{

    public function onPrepareComponentParams($arParams)
    {
        $arParams['SUCCESS_MESSAGE'] = !empty($arParams['SUCCESS_MESSAGE']) ? $arParams['SUCCESS_MESSAGE'] : Loc::getMessage('SUCCESS_MESSAGE');

        return $arParams;
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $arParams = $this->arParams;
        $arResult = [];
        $arErrors = [];

        $arSuccess = [
            'SUCCESS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arParams['SUCCESS_MESSAGE']
                ],
            ],
            'USER_ID' => '',
            'REDIRECT_URL' => !empty($arParams['REDIRECT_URL']) ? $arParams['REDIRECT_URL'] : '',
        ];

        // form is submited
        if (!empty($_REQUEST['CONFIRM_AJAX_SUBMIT'])) {

            if (!check_bitrix_sessid() && $bCaptcha)
                $arErrors[] = [
                    'NAME' => 'BITRIX_SESSID',
                    'MESSAGE' => Loc::getMessage('ERROR_BITRIX_SESSID'),
                ];

            if (!$this->checkCaptcha())
                $arErrors[] = [
                    'NAME' => 'CAPTCHA',
                    'MESSAGE' => Loc::getMessage('ERROR_CAPTCHA'),
                ];

            $arValidate = $this->validateData();
            if (is_array($arValidate))
                $arErrors = array_merge($arErrors, $arValidate);

            if (empty($arErrors)) {

                $arFilter = [];

                if (!empty($_REQUEST['USER_ID']))
                    $arFilter['ID'] = $_REQUEST['USER_ID'];

                if (!empty($_REQUEST['CONFIRM_EMAIL']))
                    $arFilter['EMAIL'] = $_REQUEST['CONFIRM_EMAIL'];

                $arUser = '';
                if (!empty($arFilter))
                    $arUser = \CUser::GetList($by = 'ID', $order = 'DESC', ['ID' => $arFilter])->fetch();

                if (!empty($_REQUEST['CONFIRM_CODE']) && !empty($arUser['CONFIRM_CODE']) && $_REQUEST['CONFIRM_CODE'] == $arUser['CONFIRM_CODE']) {

                    $obUser = new \CUser;
                    $obUser->Update($arUser['ID'], ['ACTIVE' => 'Y']);

                    // auth
                    if ($arParams['AUTH_AFTER_REG'] == 'Y') {
                        global $USER;
                        $USER->Authorize($arUser['ID'], true);
                    }

                    $arSuccess['USER_ID'] = $arUser['ID'];
                    $arResult = $arSuccess;
                } else
                    $arErrors[] = [
                        'NAME' => 'CONFIRM_CODE',
                        'MESSAGE' => Loc::getMessage('ERROR_CONFIRM'),
                    ];
            }

            if (!empty($arErrors))
                $arResult['ERRORS'] = $arErrors;
        }

        // captcha
        if (Option::get('main', 'captcha_registration', 'N') == 'Y')
            $arResult['CAPTCHA'] = $this->getCaptcha();

        // reload captcha
        if (!empty($_REQUEST['AJAX_RELOAD_CAPTCHA'])) {
            $APPLICATION->RestartBuffer();
            die(Json::encode(['CAPTCHA' => $arResult['CAPTCHA']]));
        }

        // form is submited
        if (!empty($_REQUEST['CONFIRM_AJAX_SUBMIT'])) {
            $APPLICATION->RestartBuffer();
            die(Json::encode($arResult));
        }

        $this->arResult = $arResult;
        $this->includeComponentTemplate();

        return true;
    }

    public function validateData()
    {
        $arErrors = [];

        $arParams = $this->arParams;

        if (empty($_REQUEST['USER_ID']) && empty($_REQUEST['CONFIRM_EMAIL']))
            $arErrors[] = [
                'NAME' => 'CONFIRM_EMAIL',
                'MESSAGE' => Loc::getMessage('ERROR_CONFIRM_EMAIL'),
            ];

        return !empty($arErrors) ? $arErrors : true;
    }

    public function getCaptcha()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/classes/general/captcha.php';
        $cpt = new \CCaptcha();
        $captchaPass = Option::get('main', 'captcha_password', '');
        $cpt->SetCodeCrypt($captchaPass);

        return [
            'CAPTCHA_CODE' => $cpt->GetCodeCrypt(),
            'SRC' => '/bitrix/tools/captcha.php?captcha_code=' . $cpt->GetCodeCrypt()
        ];
    }

    public function checkCaptcha()
    {
        global $APPLICATION;

        if (Option::get('main', 'captcha_registration', 'N') != 'Y')
            return true;

        if (!$APPLICATION->CaptchaCheckCode($_REQUEST["CAPTCHA"], $_REQUEST['CAPTCHA_CODE']))
            return false;

        return true;
    }

}

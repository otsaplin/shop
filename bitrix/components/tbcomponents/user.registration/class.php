<?php

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class TbUserRegistrationComponent extends CBitrixComponent
{

    protected $arUserFields = [
        'LOGIN',
        'EMAIL',
        'PERSONAL_PHONE',
        'NAME',
        'SECOND_NAME',
        'LAST_NAME',
        'FIO',
        'PERSONAL_PROFESSION',
        'PERSONAL_WWW',
        'PERSONAL_GENDER',
        'PERSONAL_BIRTHDAY',
        'PERSONAL_CITY',
        'PERSONAL_COUNTRY',
        'PERSONAL_ZIP',
        'PERSONAL_STREET',
        'WORK_COMPANY',
        'WORK_DEPARTMENT',
        'WORK_POSITION',
        'WORK_WWW',
        'WORK_PHONE',
        'PASSWORD',
        'CONFIRM_PASSWORD'
    ];

    public function onPrepareComponentParams($arParams)
    {
        $arParams['FORM_ID'] = !empty($arParams['FORM_ID']) ? $arParams['FORM_ID'] : 'REG';

        if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') {
            if (!in_array('PERSONAL_PHONE', $arParams['SHOW_FIELDS']))
                $arParams['SHOW_FIELDS'][] = 'PERSONAL_PHONE';
            if (!in_array('PERSONAL_PHONE', $arParams['REQUIRED_FIELDS']))
                $arParams['REQUIRED_FIELDS'][] = 'PERSONAL_PHONE';
        }

        if (Option::get('main', 'new_user_email_auth', 'N') == 'Y')
            if (!in_array('EMAIL', $arParams['SHOW_FIELDS']))
                $arParams['SHOW_FIELDS'][] = 'EMAIL';

        if (Option::get('main', 'new_user_email_required', 'N') == 'Y')
            if (!in_array('EMAIL', $arParams['REQUIRED_FIELDS']))
                $arParams['REQUIRED_FIELDS'][] = 'EMAIL';

        if (in_array('PASSWORD', $arParams['SHOW_FIELDS'])) {
            unset($arParams['SHOW_FIELDS'][array_search('PASSWORD', $arParams['SHOW_FIELDS'])]);
            unset($arParams['SHOW_FIELDS'][array_search('CONFIRM_PASSWORD', $arParams['SHOW_FIELDS'])]);

            $arParams['SHOW_FIELDS'][] = 'PASSWORD';
            $arParams['REQUIRED_FIELDS'][] = 'PASSWORD';
            $arParams['SHOW_FIELDS'][] = 'CONFIRM_PASSWORD';
            $arParams['REQUIRED_FIELDS'][] = 'CONFIRM_PASSWORD';
        }

        $arParams['USE_PRIVACY_POLICY'] = !empty($arParams['USE_PRIVACY_POLICY']) ? $arParams['USE_PRIVACY_POLICY'] : 'Y';
        $arParams['PRIVACY_POLICY_CHECKED'] = !empty($arParams['PRIVACY_POLICY_CHECKED']) ? $arParams['PRIVACY_POLICY_CHECKED'] : 'Y';
        $arParams['PRIVACY_POLICY_TEXT'] = !empty($arParams['PRIVACY_POLICY_TEXT']) ? $arParams['PRIVACY_POLICY_TEXT'] : Loc::getMessage('PRIVACY_POLICY_TEXT');

        $arParams['SUCCESS_MESSAGE'] = !empty($arParams['SUCCESS_MESSAGE']) ? $arParams['SUCCESS_MESSAGE'] : Loc::getMessage('SUCCESS_MESSAGE');

        return $arParams;
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $arParams = $this->arParams;
        $arResult = [];
        $arErrors = [];

        if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') {
            $arResult['NEW_USER_PHONE_AUTH'] = 'Y';
            $arResult['SMS_TIME_DIFF'] = 0;

            if (!empty($_SESSION['SMS_REG']['NEXT_TIME']) && $_SESSION['SMS_REG']['NEXT_TIME'] > time())
                $arResult['SMS_TIME_DIFF'] = $_SESSION['SMS_REG']['NEXT_TIME'] - time();
        }

        // form is submited
        if (!empty($_REQUEST['REG_AJAX_SUBMIT'])) {

            if (!check_bitrix_sessid())
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

            // sms code
            if (empty($arErrors) && $arResult['NEW_USER_PHONE_AUTH'] = 'Y' && !empty($_REQUEST['PERSONAL_PHONE'])) {

                $arSms = $this->sendSms($_REQUEST['PERSONAL_PHONE']);

                if (!empty($arSms['ERROR']))
                    $arErrors[] = [
                        'NAME' => 'PERSONAL_PHONE',
                        'MESSAGE' => $arSms['ERROR'],
                    ];

                if (!empty($arSms['SENT']))
                    $arResult['SMS_REG'] = [
                        'NEXT_TIME' => $arSms['NEXT_TIME'],
                        'SMS_TIME_DIFF' => ($arSms['NEXT_TIME'] > time()) ? $arSms['NEXT_TIME'] - time() : 0,
                    ];
            }

            // registration
            if (empty($arErrors) && empty($arSms)) {
                $arReg = $this->doRegUser();

                if (!empty($arReg['ERRORS']))
                    $arErrors = array_merge($arErrors, $arReg['ERRORS']);

                if (!empty($arReg['SUCCESS']))
                    $arResult = array_merge($arResult, $arReg);

                if (empty($arErrors) && empty($arResult['SUCCESS']))
                    $arErrors[] = [
                        'NAME' => 'SYSTEM_ERROR',
                        'MESSAGE' => Loc::getMessage('SYSTEM_ERROR'),
                    ];
            }

            if (!empty($arErrors))
                $arResult['ERRORS'] = $arErrors;
        }

        if (Option::get('main', 'captcha_registration', 'N') == 'Y')
            $arResult['CAPTCHA'] = $this->getCaptcha();

        // reload captcha
        if (!empty($_REQUEST['AJAX_RELOAD_CAPTCHA'])) {
            $APPLICATION->RestartBuffer();
            die(Json::encode(['CAPTCHA' => $arResult['CAPTCHA']]));
        }

        // form is submited
        if (!empty($_REQUEST['REG_AJAX_SUBMIT'])) {
            $APPLICATION->RestartBuffer();
            die(Json::encode($arResult));
        }

        $this->arResult = $arResult;

        $this->includeComponentTemplate();

        return true;
    }

    public function doRegUser()
    {
        $arParams = $this->arParams;
        $event = new \CEvent;
        $arFields = [];

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

        $arExistUser = $this->checkExistUser();
        if ($arExistUser) {
            $arSuccess['USER_ID'] = $arExistUser['ID'];

            return $arSuccess;
        }

        $_REQUEST['PHONE_NUMBER'] = !empty($_REQUEST['PHONE_NUMBER']) ? $_REQUEST['PHONE_NUMBER'] : $_SESSION['SMS_REG']['PHONE'];

        foreach ($this->arUserFields as $field) {
            if (!empty($_REQUEST[$field]))
                $arFields[$field] = $_REQUEST[$field];
        }

        // FIO
        if (!empty($_REQUEST['FIO'])) {
            $arFIo = explode(' ', $_REQUEST['FIO']);
            $arFields['LAST_NAME'] = !empty($arFields['LAST_NAME']) ? $arFields['LAST_NAME'] : $arFIo[0];
            $arFields['NAME'] = !empty($arFields['NAME']) ? $arFields['NAME'] : $arFIo[1];
            $arFields['SECOND_NAME'] = !empty($arFields['SECOND_NAME']) ? $arFields['SECOND_NAME'] : $arFIo[2];
        }

        // password
        if (empty($arFields['PASSWORD'])) {
            $arFields['PASSWORD'] = substr(md5(rand(0, 9999999)), 0, 7);
            $arFields['CONFIRM_PASSWORD'] = $arFields['PASSWORD'];
        }

        // login
        if (Option::get('main', 'new_user_email_auth', 'N') == 'Y') {
            $arFields['LOGIN'] = $_REQUEST['EMAIL'];
        }

        if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') {
            $arFields['LOGIN'] = $_SESSION['SMS_REG']['PHONE'];
            $arFields['PHONE_NUMBER'] = '+' . $_SESSION['SMS_REG']['PHONE'];
        }

        // groups
        $arGroups = [];
        $strGroups = Option::get('main', 'new_user_registration_def_group', '');
        if (!empty($strGroups))
            $arGroups = explode(',', $strGroups);

        $arFields['GROUP_ID'] = $arGroups;

        // active and email confirm
        if (Option::get('main', 'new_user_registration_email_confirmation', 'N') == 'Y') {
            $arFields['ACTIVE'] = 'N';
            $arFields['CONFIRM_CODE'] = randString(8);
        }

        $obUser = new \CUser;
        $idUser = $obUser->add($arFields);

        if (intval($idUser) > 0) {

            unset($_SESSION['SMS_REG']);

            $arFields['USER_ID'] = $idUser;
            $arSuccess['USER_ID'] = $idUser;

            // E-mail confirm
            if (Option::get('main', 'new_user_registration_email_confirmation', 'N') == 'Y') {

                $arSuccess['SUCCESS'][] = [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => Loc::getMessage('EMAIL_CONFIRM_MESSAGE'),
                ];

                $event->SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arFields);
            } else {
                $event->SendImmediate("NEW_USER", SITE_ID, $arFields);
            }

            // auth
            if ($arParams['AUTH_AFTER_REG'] == 'Y' && Option::get('main', 'new_user_registration_email_confirmation', 'N') != 'Y') {
                global $USER;
                $USER->Authorize($idUser, true);
            }

            return $arSuccess;
        } else
            return [
                'ERRORS' => [
                    0 => [
                        'NAME' => 'SYSTEM',
                        'MESSAGE' => $obUser->LAST_ERROR,
                    ]
                ]
            ];
    }

    public function checkExistUser()
    {
        $arParams = $this->arParams;

        if (Option::get('main', 'new_user_phone_auth', 'N') !== 'Y')
            return false;

        if (empty($_SESSION['SMS_REG']['PHONE']))
            return false;

        if ($arParams['AUTH_AFTER_REG'] !== 'Y')
            return false;

        $arUser = \CUser::GetList($by = 'id', $order = 'desc', ['LOGIN' => $_SESSION['SMS_REG']['PHONE']])->fetch();

        if ($arUser) {
            global $USER;
            
            unset($_SESSION['SMS_REG']);
            
            $USER->Authorize($arUser['ID'], true);
        }

        return $arUser;
    }

    public function validateData()
    {
        $arErrors = [];

        $arParams = $this->arParams;

        foreach ($arParams['REQUIRED_FIELDS'] as $field) {

            if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y' && $field == 'PERSONAL_PHONE' && !empty($_SESSION['SMS_REG']))
                continue;

            if (empty($_REQUEST[$field]))
                $arErrors[] = [
                    'NAME' => $field,
                    'MESSAGE' => Loc::getMessage('ERROR_VALIDATE_FIELD', ['#FIELD_NAME#' => Loc::getMessage('FIELD_' . $field)]),
                ];
        }

        if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y' &&
                empty($_REQUEST['PERSONAL_PHONE']) &&
                !empty($_SESSION['SMS_REG']['CODE']) &&
                $_SESSION['SMS_REG']['CODE'] != $_REQUEST['SMSCODE'])
            $arErrors[] = [
                'NAME' => 'SMSCODE',
                'MESSAGE' => Loc::getMessage('ERROR_SMS_CODE'),
            ];

        if ($arParams['USE_PRIVACY_POLICY'] == 'Y' && $_REQUEST['PRIVACY_POLICY'] !== 'Y')
            $arErrors[] = [
                'NAME' => 'PRIVACY_POLICY',
                'MESSAGE' => Loc::getMessage('ERROR_PRIVACY_POLICY'),
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

    public function sendSms($phone)
    {
        $phone = $this->phoneNormalize($phone);

        if (empty($phone))
            return [
                'ERROR' => Loc::getMessage('ERROR_PHONE'),
            ];

        if (!empty($_SESSION['SMS_REG']['NEXT_TIME']) && $_SESSION['SMS_REG']['NEXT_TIME'] > time()) {

            if ($_SESSION['SMS_REG']['PHONE'] == $phone)
                return $_SESSION['SMS_REG'];

            return [
                'ERROR' => Loc::getMessage('ERROR_RESEND_SMS', ['#TIME_DIFF#' => FormatDate('sdiff', time() - ($_SESSION['SMS_REG']['NEXT_TIME'] - time()))]),
            ];
        }

        $code = rand(1000, 9999);

        $sms = new \Bitrix\Main\Sms\Event(
                "SMS_USER_CONFIRM_NUMBER", [
            "USER_PHONE" => $phone,
            "CODE" => $code,
                ]
        );

        $smsResult = $sms->send(true);

        if (!$smsResult->isSuccess()) {

            return [
                'ERROR' => $smsResult->getErrorMessages(),
            ];
        } else {
            $_SESSION['SMS_REG'] = [
                'SENT' => 'Y',
                'PHONE' => $phone,
                'CODE' => $code,
                'TIME' => time(),
                'NEXT_TIME' => time() + 2 * 60,
            ];

            return $_SESSION['SMS_REG'];
        }
    }

    public function phoneNormalize($phone)
    {
        $result = $phone;

        if (empty($phone))
            return $result;

        $phone = preg_replace('~\D+~', '', $phone);
        if (strlen($phone) < 11)
            $phone = '7' . $phone;

        if ($phone[0] == '8')
            $phone[0] = '7';

        if (strlen($phone) > 11)
            $phone = substr($phone, 0, 11);

        if (!empty($phone))
            $result = $phone;

        return $result;
    }

    public function checkCaptcha()
    {
        global $APPLICATION;

        if (Option::get('main', 'captcha_registration', 'N') != 'Y')
            return true;

        if (!empty($_SESSION['SMS_REG']))
            return true;

        if (!$APPLICATION->CaptchaCheckCode($_REQUEST["CAPTCHA"], $_REQUEST['CAPTCHA_CODE']))
            return false;

        return true;
    }

}

<?
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $USER;

Loc::loadMessages(__FILE__);
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . $componentPath . '/class.php');

\CJSCore::RegisterExt(
        'langInit', [
    'lang' => $templateFolder . '/lang/ru/template.php',
        ]
);
\CJSCore::Init(["langInit"]);

$asset = Asset::getInstance();
$asset->addJs($templateFolder . '/countdown-timer/jquery-countdown-timer-control.js');
if (!IsModuleInstalled('tb.shop'))
    $asset->addJs($templateFolder . '/additional.js');
?>
<? if ($USER->isAuthorized()) { ?>
    <p><?= Loc::getMessage('AUTH_YET'); ?></p>
<? } else { ?>
    <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" style="display:none;" />
    <form name="<?= $arParams['FORM_ID']; ?>" id="<?= $arParams['FORM_ID']; ?>" action="<?= $APPLICATION->getCurPage(); ?>" method="POST" onsubmit="return onSubmitRegForm(this);">
        <?= bitrix_sessid_post(); ?>
        <input type="hidden" name="REG_AJAX_SUBMIT" value="Y" />
        <div class="form-wrap">
            <? foreach ($arParams['SHOW_FIELDS'] as $fieldName) { ?>
                <?
                switch ($fieldName) {
                    case 'PERSONAL_PHONE':
                        $additional = !empty($_SESSION['SMS_REG']['SENT']) ? 'value="' . $_SESSION['SMS_REG']['PHONE'] . '" disabled="disabled"' : '';
                        ?>
                        <div class="form-group personal-phone">
                            <a href="#" class="a_yellow" <? echo empty($_SESSION['SMS_REG']['SENT']) ? 'style="display:none;"' : ''; ?> onClick="return regFormChangeNumber(this);"><?= Loc::getMessage('CHANGE_NUMBER'); ?></a>
                            <input type="text" id="<?= $arParams['FORM_ID']; ?>_<?= $fieldName; ?>" name="<?= $fieldName; ?>" class="form-control phone_masked" placeholder="<?= Loc::getMessage('FIELD_' . $fieldName); ?>" <?= $additional; ?> />
                        </div>
                        <?
                        break;
                    default:
                        ?>
                        <div class="form-group">
                            <?
                            $class = 'form-control';

                            if (strstr($fieldName, 'PHONE'))
                                $class .= ' phone_masked';

                            $type = strstr($fieldName, 'PASSWORD') ? 'password' : 'text';
                            ?>
                            <input type="<?= $type; ?>" id="<?= $arParams['FORM_ID']; ?>_<?= $fieldName; ?>" name="<?= $fieldName; ?>" class="<?= $class; ?>" placeholder="<?= Loc::getMessage('FIELD_' . $fieldName); ?>" />
                        </div>
                        <?
                        break;
                }
                ?>
            <? } ?>
            <? if (!empty($arResult['CAPTCHA'])) { ?>
                <div class="form-group row reg-captcha" style="<? echo empty($_SESSION['SMS_REG']['SENT']) ? '' : 'display:none;'; ?>">
                    <div class="col-5">
                        <input type="hidden" name="CAPTCHA_CODE" value="<?= $arResult['CAPTCHA']['CAPTCHA_CODE']; ?>" />
                        <input type="text" id="<?= $arParams['FORM_ID']; ?>_CAPTCHA" name="CAPTCHA" class="form-control" placeholder="<?= Loc::getMessage('FORM_CAPTCHA'); ?>" />
                    </div>
                    <div class="col-7">
                        <img class="captcha__img" src="<?= $arResult['CAPTCHA']['SRC']; ?>" />
                        <a class="captcha__reload" href="#" onclick="return reloadCaptcha(this);"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            <? } ?>
            <? if ($arResult['NEW_USER_PHONE_AUTH'] == 'Y') { ?>
                <div class="form-group row" style="<? echo!empty($_SESSION['SMS_REG']['SENT']) ? '' : 'display:none;'; ?>">
                    <div class="col-5">
                        <input type="text" id="<?= $arParams['FORM_ID']; ?>_SMSCODE" name="SMSCODE" class="form-control" placeholder="<?= Loc::getMessage('FORM_SMSCODE'); ?>" />
                    </div>
                    <div class="col-7 text-center text-black-50 resms-wrap" onclick="return reSendSms(this);">
                        <div class="float-left mt-2 mr-2"><?= Loc::getMessage('RESEND_SMS'); ?></div>
                        <div class="sms-timer float-left mt-2" data-seconds-left="<? echo isset($arResult['SMS_TIME_DIFF']) ? $arResult['SMS_TIME_DIFF'] : '0'; ?>"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <? } ?>
            <? if ($arParams['USE_PRIVACY_POLICY'] == 'Y') { ?>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="<?= $arParams['FORM_ID']; ?>_registration_personal" name="PRIVACY_POLICY" value="Y" <? if ($arParams['PRIVACY_POLICY_CHECKED'] == 'Y') { ?>checked="checked"<? } ?>>
                    <label class="form-check-label" for="<?= $arParams['FORM_ID']; ?>_registration_personal"><?= html_entity_decode($arParams['PRIVACY_POLICY_TEXT']); ?></label>
                </div>
            <? } ?>
            <div class="text-left">
                <?
                $btnMsg = Loc::getMessage('FORM_SUBMIT_REG');
                if ($arResult['NEW_USER_PHONE_AUTH'] == 'Y' && empty($_SESSION['SMS_REG']['SENT']))
                    $btnMsg = Loc::getMessage('FORM_SUBMIT_REG_SMS');
                ?>
                <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= $btnMsg; ?>" data-loading-img="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif"><?= $btnMsg; ?></button>
            </div>
        </div>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
<? } ?>
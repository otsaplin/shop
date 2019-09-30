<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$loadingImg = $this->getFolder() . '/assets/img/loading_btn.gif';
if (IsModuleInstalled('tb.shop'))
    $loadingImg = SITE_TEMPLATE_PATH . '/assets/img/loading_btn.gif';

$asset = Asset::getInstance();
if (!IsModuleInstalled('tb.shop'))
    $asset->addJs($templateFolder . '/additional.js');
?>
<? if ($arResult['AUTHORIZED']) { ?>
    <div class="alert alert-success mt-4" role="alert">
        <ul>
            <li><?= Loc::getMessage('MAIN_AUTH_CHD_SUCCESS'); ?></li>
        </ul>
    </div>
<? } else { ?>
    <form id="CHANGE_FORM" name="CHANGE_FORM" method="post" target="_top" action="<?= POST_FORM_ACTION_URI; ?>" onsubmit="return onSubmitChangeForm(this);">
        <input type="hidden" name="<?= $arResult['FIELDS']['action']; ?>" value="Y" />
        <div class="form-wrap">
            <div class="form-group">
                <?
                $class = 'form-control';
                $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN');

                if (Option::get('main', 'new_user_email_auth', 'N') == 'Y') {
                    $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN_EMAIL');
                }

                if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') {
                    $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN_PHONE');
                    $class .= ' phone_masked';
                }
                ?>
                <input type="text" id="<?= $arResult['FIELDS']['login']; ?>" name="<?= $arResult['FIELDS']['login']; ?>" class="<?= $class; ?>" placeholder="<?= $loginMsg; ?>" value="<?= $arResult['LAST_LOGIN']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" id="<?= $arResult['FIELDS']['checkword']; ?>" name="<?= $arResult['FIELDS']['checkword']; ?>" class="form-control" placeholder="<?= Loc::getMessage('FIELD_AUTH_CHECK'); ?>" value="<?= $arResult[$arResult['FIELDS']['checkword']]; ?>" />
            </div>
            <div class="form-group">
                <input type="password" id="<?= $arResult['FIELDS']['password']; ?>" name="<?= $arResult['FIELDS']['password']; ?>" class="form-control" placeholder="<?= Loc::getMessage('FIELD_AUTH_PASSWORD'); ?>" autocomplete="off" />
            </div>
            <div class="form-group">
                <input type="password" id="<?= $arResult['FIELDS']['confirm_password']; ?>" name="<?= $arResult['FIELDS']['confirm_password']; ?>" class="form-control" placeholder="<?= Loc::getMessage('FIELD_AUTH_CONFIRM_PASSWORD'); ?>" autocomplete="off" />
            </div>
            <? if ($arResult['CAPTCHA_CODE']) { ?>
                <div class="form-group row reg-captcha">
                    <div class="col-5">
                        <input type="hidden" name="captcha_sid" value="<?= $arResult['CAPTCHA_CODE']; ?>" />
                        <input type="text" id="FORGOT_FORM_captcha_word" name="captcha_word" class="form-control" placeholder="<?= Loc::getMessage('FORM_CAPTCHA'); ?>" />
                    </div>
                    <div class="col-7">
                        <img class="captcha__img" src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA_CODE']; ?>" />
                        <a class="captcha__reload" href="#" onclick="return reloadCaptcha(this);"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            <? } ?>
            <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= Loc::getMessage('FORM_BUTTON'); ?>" data-loading-img="<?= $loadingImg; ?>"><?= Loc::getMessage('FORM_BUTTON'); ?></button>
        </div>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
<? } ?>
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
            <li><?= Loc::getMessage('MAIN_AUTH_PWD_SUCCESS'); ?></li>
        </ul>
    </div>
<? } else { ?>
    <p><?= Loc::getMessage('MAIN_AUTH_PWD_NOTE'); ?></p>
    <form class="mt-4" id="FORGOT_FORM" name="FORGOT_FORM" method="post" target="_top" action="<?= POST_FORM_ACTION_URI; ?>" onsubmit="return onSubmitForgotForm(this);">
        <input type="hidden" name="<?= $arResult['FIELDS']['action'];?>" value="Y" />
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
<?
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
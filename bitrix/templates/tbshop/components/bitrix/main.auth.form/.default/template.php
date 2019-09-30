<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

global $USER;

Loc::loadMessages(__FILE__);

$loadingImg = $this->getFolder() . '/assets/img/loading_btn.gif';
if (IsModuleInstalled('tb.shop'))
    $loadingImg = SITE_TEMPLATE_PATH . '/assets/img/loading_btn.gif';

$asset = Asset::getInstance();
if (!IsModuleInstalled('tb.shop'))
    $asset->addJs($templateFolder . '/additional.js');
?>
<? if ($USER->isAuthorized()) { ?>
    <p><?= Loc::getMessage('AUTH_YET'); ?></p>
<? } else { ?>
    <img src="<?= $loadingImg; ?>" style="display:none;" />
    <form id="<?= $arResult['FORM_ID']; ?>" name="<?= $arResult['FORM_ID']; ?>" method="post" target="_top" action="<?= POST_FORM_ACTION_URI; ?>" onsubmit="return onSubmitAuthForm(this);">
        <input type="hidden" name="<?= $arResult['FIELDS']['action']; ?>" value="Y" />
        <div class="form-wrap">
            <div class="form-group">
                <?
                $class = 'form-control';
                $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN');

                if (Option::get('main', 'new_user_email_auth', 'N') == 'Y')
                    $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN_EMAIL');

                if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') {
                    $loginMsg = Loc::getMessage('FIELD_AUTH_LOGIN_PHONE');
                    $class .= ' phone_masked';
                }
                ?>
                <input type="text" id="<?= $arResult['FIELDS']['login']; ?>" name="<?= $arResult['FIELDS']['login']; ?>" class="<?= $class; ?>" placeholder="<?= $loginMsg; ?>" />
            </div>
            <div class="form-group">
                <input type="password" id="<?= $arResult['FIELDS']['password']; ?>" name="<?= $arResult['FIELDS']['password']; ?>" class="form-control" placeholder="<?= Loc::getMessage('FIELD_AUTH_PASSWORD'); ?>" />
            </div>
            <? if ($arResult["STORE_PASSWORD"] == "Y") { ?>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="<?= $arResult['FIELDS']['remember']; ?>" name="<?= $arResult['FIELDS']['remember']; ?>" value="Y" checked="checked">
                    <label class="form-check-label" for="<?= $arResult['FIELDS']['remember']; ?>"><?= Loc::getMessage('FIELD_AUTH_REMEMBER'); ?></label>
                </div>
            <? } ?>
            <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= Loc::getMessage('FORM_BUTTON'); ?>" data-loading-img="<?= $loadingImg; ?>"><?= Loc::getMessage('FORM_BUTTON'); ?></button>
        </div>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
    <? if (!empty($arResult['AUTH_REGISTER_URL']) || !empty($arResult['AUTH_FORGOT_PASSWORD_URL'])) { ?>
        <div id="<?= $arResult['FORM_ID']; ?>__links-block" class="mt-3">
            <? if (!empty($arResult['AUTH_REGISTER_URL'])) { ?>
                <div class="float-left mr-2"><a href="<?= $arResult['AUTH_REGISTER_URL']; ?>"><?= Loc::getMessage('URL_REGISTRATION'); ?></a></div>
            <? } ?>
            <? if (!empty($arResult['AUTH_REGISTER_URL']) && !empty($arResult['AUTH_FORGOT_PASSWORD_URL'])) { ?>
                <div class="float-left mr-2">|</div>
            <? } ?>
            <? if (!empty($arResult['AUTH_FORGOT_PASSWORD_URL'])) { ?>
                <div class="float-left"><a href="<?= $arResult['AUTH_FORGOT_PASSWORD_URL']; ?>"><?= Loc::getMessage('URL_FORGET'); ?></a></div>
            <? } ?>
            <div class="clearfix"></div>
        </div>
    <? } ?>
<? } ?>
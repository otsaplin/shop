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
<? if (in_array($arResult['MESSAGE_CODE'], ['E02', 'E03', 'E06'])) { ?>
    <div class="alert alert-success mt-4" role="alert">
        <ul>
            <li><?= $arResult['MESSAGE_TEXT']; ?></li>
        </ul>
    </div>
<? } ?>
<? if ($arResult["SHOW_FORM"]) { ?>
    <img src="<?= $loadingImg; ?>" style="display:none;" />
    <form id="CONFIRM_FORM" name="CONFIRM_FORM" method="post" target="_top" action="<?= $arResult["FORM_ACTION"]; ?>" onsubmit="return onSubmitConfirmForm(this);">
        <input type="hidden" name="CONFIRM_FORM" value="Y" />
        <input type="hidden" name="<?= $arParams["USER_ID"] ?>" value="<?= $arResult["USER_ID"] ?>" />
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
                <input type="text" id="<?= $arParams['LOGIN']; ?>" name="<?= $arParams['LOGIN']; ?>" class="<?= $class; ?>" placeholder="<?= $loginMsg; ?>" value="<?= $arResult["LOGIN"]; ?>" />
            </div>
            <div class="form-group">
                <input type="text" id="<?= $arParams["CONFIRM_CODE"]; ?>" name="<?= $arParams["CONFIRM_CODE"]; ?>" class="form-control" placeholder="<?= Loc::getMessage('FIELD_AUTH_CONFIRM_CODE'); ?>" value="<?= $arResult["CONFIRM_CODE"]; ?>" />
            </div>
            <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= Loc::getMessage('FORM_BUTTON'); ?>" data-loading-img="<?= $loadingImg; ?>"><?= Loc::getMessage('FORM_BUTTON'); ?></button>
        </div>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
<? } ?>
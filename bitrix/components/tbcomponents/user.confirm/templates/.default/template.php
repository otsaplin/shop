<?

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $APPLICATION;
global $USER;

Loc::loadMessages(__FILE__);

$asset = Asset::getInstance();
if (!IsModuleInstalled('tb.shop'))
    $asset->addJs($templateFolder . '/additional.js');
?>
<? if ($USER->isAuthorized()) { ?>
    <p><?= Loc::getMessage('AUTH_YET'); ?></p>
<? } else { ?>
    <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" style="display:none;" />
    <form name="USER_CONFIRM" id="USER_CONFIRM" action="<?= $APPLICATION->getCurPage(); ?>" method="POST" onsubmit="return onSubmitConfirmForm(this);">
        <?= bitrix_sessid_post(); ?>
        <input type="hidden" name="confirm_registration" value="Y" />
        <input type="hidden" name="CONFIRM_AJAX_SUBMIT" value="Y" />
        <? if (!empty($_REQUEST['confirm_user_id'])) { ?>
            <input type="hidden" name="USER_ID" value="<?= $_REQUEST['confirm_user_id']; ?>" />
        <? } ?>
        <div class="form-wrap">
            <? if (empty($_REQUEST['confirm_user_id'])) { ?>
                <div class="form-group">
                    <input type="text" id="CONFIRM_EMAIL" name="CONFIRM_EMAIL" class="form-control" placeholder="<?= Loc::getMessage('FIELD_CONFIRM_EMAIL'); ?>" />
                </div>
            <? } ?>
            <div class="form-group">
                <input type="text" id="CONFIRM_CODE" name="CONFIRM_CODE" class="form-control" placeholder="<?= Loc::getMessage('FIELD_CONFIRM_CODE'); ?>" value="<?=$_REQUEST['confirm_code'];?>" />
            </div>
            <? if (!empty($arResult['CAPTCHA'])) { ?>
                <div class="form-group row reg-captcha">
                    <div class="col-5">
                        <input type="hidden" name="CAPTCHA_CODE" value="<?= $arResult['CAPTCHA']['CAPTCHA_CODE']; ?>" />
                        <input type="text" id="CONFIRM_CAPTCHA" name="CAPTCHA" class="form-control" placeholder="<?= Loc::getMessage('FORM_CAPTCHA'); ?>" />
                    </div>
                    <div class="col-7">
                        <img class="captcha__img" src="<?= $arResult['CAPTCHA']['SRC']; ?>" />
                        <a class="captcha__reload" href="#" onclick="return reloadCaptcha(this);"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            <? } ?>
            <button type="submit" class="btn btn-md btn_red" data-loading-text="<?= Loc::getMessage('FORM_BUTTON'); ?>" data-loading-img="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif"><?= Loc::getMessage('FORM_BUTTON'); ?></button>
        </div>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
<? } ?>
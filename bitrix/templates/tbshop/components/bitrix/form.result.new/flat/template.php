<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $APPLICATION;
?>
<img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif" style="display:none;" />
<iframe style="display:none;" id="IFRAM_<?= $arResult['arForm']['SID']; ?>" name="IFRAM_<?= $arResult['arForm']['SID']; ?>"></iframe>
<form target="IFRAM_<?= $arResult['arForm']['SID']; ?>" id="<?= $arResult['arForm']['SID']; ?>" name="<?= $arResult['arForm']['SID']; ?>" action="<?= $APPLICATION->getCurPage(); ?>" method="POST" enctype="multipart/form-data" onsubmit="onSubmitForm(this);">
    <?= bitrix_sessid_post(); ?>
    <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID']; ?>">
    <input type="hidden" name="web_form_submit" value="1" />
    <? foreach ($arResult['arQuestions'] as $arQuestion) { ?>
        <?
        if ($arQuestion['FIELD_TYPE'] == 'text') {
            $class = 'form-control';

            if (strstr($arQuestion['COMMENTS'], 'PHONE'))
                $class .= ' phone_masked';
            ?>
            <div class="form-group">
                <input type="text" id="<?= $arQuestion['SID']; ?>" name="form_<?= $arQuestion['FIELD_TYPE']; ?>_<?= $arQuestion['ID']; ?>" class="<?= $class; ?>" placeholder="<?= $arQuestion['TITLE']; ?>" />
            </div>
        <? } ?>
    <? } ?>
    <div class="text-center">
        <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= $arResult['arForm']['BUTTON']; ?>" data-loading-img="<?= SITE_TEMPLATE_PATH; ?>/assets/img/loading_btn.gif"><?= $arResult['arForm']['BUTTON']; ?></button>
    </div>
    <div class="alert alert-danger mt-4" role="alert" style="display: none;"></div>
    <div class="alert alert-success mt-4" role="alert" style="display: none;"><?= $arParams['SUCCESS_TEXT']; ?></div>
</form>
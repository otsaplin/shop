<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

global $APPLICATION;

Loc::loadMessages(__FILE__);

$loadingImg = $this->getFolder() . '/assets/img/loading_btn.gif';
if (IsModuleInstalled('tb.shop'))
    $loadingImg = SITE_TEMPLATE_PATH . '/assets/img/loading_btn.gif';
?>
<? if (!empty($arResult['ERRORS'])) { ?>
    <div class="alert alert-danger mt-4" role="alert">
        <ul>
            <? foreach ($arResult['ERRORS'] as $arError) { ?>
                <li><?= $arError['MESSAGE']; ?></li>
            <? } ?>
        </ul>
    </div>
<? } ?>
<? if (empty($arResult['ERRORS'])) { ?>
    <img src="<?= $loadingImg; ?>" style="display:none;" />
    <iframe id="FRAME_<?= $arParams["ID_FORM"]; ?>" name="FRAME_<?= $arParams["ID_FORM"]; ?>" style="display:none;"></iframe>
    <form id="FORM_<?= $arParams["ID_FORM"]; ?>" name="FORM_<?= $arParams["ID_FORM"]; ?>" target="FRAME_<?= $arParams["ID_FORM"]; ?>" action="<?= $APPLICATION->GetCurPage(true); ?>" onsubmit="return TbFormSubmit(this);" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="FORM_<?= $arParams["ID_FORM"]; ?>" value="1" />
        <? if (!empty($arResult['DATA']['ID'])) { ?>
            <input type="hidden" name="ID" value="<?= $arResult['DATA']['ID']; ?>" />
        <? } ?>
        <?= bitrix_sessid_post(); ?>
        <? for ($i = 1; $i <= intval($arParams["CTN_FIELDS"]); $i++) { ?>
            <?
            $id = $arParams["ID_FORM"] . '_' . $arParams["FIELD_CODE_" . $i];
            $name = $arParams["FIELD_CODE_" . $i];
            $data = '';

            if (!empty($arResult['DATA'])) {
                // is it property?
                if (strstr($arParams["FIELD_SAVE_" . $i], 'PROPERTY_')) {
                    
                } else {
                    // is it filed?
                    $data = $arResult['DATA'][$arParams["FIELD_SAVE_" . $i]];
                }
            }
            ?>
            <?
            switch ($arParams["FIELD_TYPE_" . $i]) {

                case 'text':
                case 'phone':
                case 'email':
                    ?>
                    <?
                    $type = ($arParams["FIELD_TYPE_" . $i] == 'password') ? 'password' : 'text';

                    $class = 'form-control';
                    if ($arParams["FIELD_TYPE_" . $i] == 'phone')
                        $class .= ' phone_masked';
                    ?>
                    <div class="form-group">
                        <label for="<?= $id; ?>"><?= $arParams["FIELD_NAME_" . $i]; ?></label>
                        <input type="<?= $type; ?>" name="<?= $name; ?>" id="<?= $id; ?>" class="<?= $class; ?>" value="<?= $data; ?>" />
                    </div>
                    <? break; ?>

                <? case 'file': ?>
                    <div class="form-group">
                        <label for="<?= $id; ?>"><?= $arParams["FIELD_NAME_" . $i]; ?></label>
                        <input type="file" name="<?= $name; ?>[]" id="<?= $id; ?>" multiple="multiple">
                        <script>
                            $(function () {

                                $('#<?= $id; ?>').filer({
                                    limit: <? echo ($arParams["FIELD_MULTIPLE_" . $i] == 'Y') ? 'null' : '1'; ?>,
                                    showThumbs: true,
                                    addMore: <? echo ($arParams["FIELD_MULTIPLE_" . $i] == 'Y') ? 'true' : 'false'; ?>,
                                    extensions: <? echo (!empty($arParams["FIELD_EXTENSIONS_" . $i])) ? \CUtil::PhpToJSObject($arParams["FIELD_EXTENSIONS_" . $i]) : 'null'; ?>,
                                    captions: <?= \CUtil::PhpToJSObject($arResult['FILER_CAPTIONS']); ?>,
                                    onRemove: function (itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
                                        $(boxEl)
                                                .parents('form')
                                                .first()
                                                .append('<input type="hidden" class="DEL_FILE_PROPVALID" name="DEL_FILE_PROPVALID[]" value="' + file.propValId + '" />');
                                    },
                                    files: <? echo (!empty($arResult['DATA']['FILES'][$arParams["FIELD_CODE_" . $i]]['FILER'])) ? \CUtil::PhpToJSObject($arResult['DATA']['FILES'][$arParams["FIELD_CODE_" . $i]]['FILER']) : 'null'; ?>
                                });

                            })
                        </script>
                    </div>
                    <? break; ?>
            <? } ?>
        <? } ?>
        <? if (!empty($arResult['CAPTCHA'])) { ?>
            <div class="form-group row reg-captcha">
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
        <button type="submit" class="btn btn-md btn-primary" data-loading-text="<?= Loc::getMessage('FORM_BUTTON'); ?>" data-loading-img="<?= $loadingImg; ?>"><?= Loc::getMessage('FORM_BUTTON'); ?></button>
        <div class="alert alert-danger mt-4" role="alert" style="display: none;"><ul></ul></div>
        <div class="alert alert-success mt-4" role="alert" style="display: none;"><ul></ul></div>
    </form>
<? } ?>
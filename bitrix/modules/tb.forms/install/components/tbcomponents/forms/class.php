<?php

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/local/log.txt");

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Localization\Loc;
use \TB\Forms\Main as TbMain;

Loc::loadMessages(__FILE__);

class TbFormsComponent extends CBitrixComponent
{

    var $data = [];

    public function onPrepareComponentParams($arParams)
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            die('Error module include.');

        $arParams['SUCCESS_MESSAGE'] = !empty($arParams['SUCCESS_MESSAGE']) ? $arParams['SUCCESS_MESSAGE'] : Loc::getMessage('SUCCESS_MESSAGE');

        for ($i = 1; $i <= $arParams["CTN_FIELDS"]; $i++) {

            if ($arParams['FIELD_TYPE_' . $i] !== 'file')
                continue;

            $arParams['FIELD_MULTIPLE_' . $i] = 'N';

            if (in_array($arParams['FIELD_SAVE_' . $i], ['PREVIEW_PICTURE', 'DETAIL_PICTURE']))
                $arParams['FIELD_EXTENSIONS_' . $i] = ['jpg', 'gif', 'bmp', 'png', 'jpeg'];

            if (strstr($arParams['FIELD_SAVE_' . $i], 'PROPERTY_')) {
                $arProp = \CIBlockProperty::GetList(["SORT" => "DESC"], ["IBLOCK_ID" => $arParams["IBLOCK_ID"], "CODE" => str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])])->fetch();

                if (!$arProp)
                    continue;

                if ($arProp['MULTIPLE'] == 'Y')
                    $arParams['FIELD_MULTIPLE_' . $i] = 'Y';

                if (!empty($arProp['FILE_TYPE'])) {
                    $arProp['FILE_TYPE'] = str_replace(' ', '', $arProp['FILE_TYPE']);
                    $arParams['FIELD_EXTENSIONS_' . $i] = explode(',', $arProp['FILE_TYPE']);
                }
            }
        }

        return $arParams;
    }

    public function executeComponent()
    {
        global $APPLICATION;

        if (!\Bitrix\Main\Loader::includeModule('tb.forms') ||
                !\Bitrix\Main\Loader::includeModule('iblock'))
            die('Error module include.');

        $obForm = new TbMain();
        $arParams = $this->arParams;
        $arResult = [];
        $arErrors = [];

        // check before events
        foreach (\GetModuleEvents('tb.forms', 'OnBeforeProcessing', true) as $arEvent)
            if (\ExecuteModuleEventEx($arEvent, [&$_REQUEST, &$arParams, &$arResult]) === false)
                $arErrors["ERRORS"][] = [
                    "MESSAGE" => $arResult["BEFORE_ERROR_MESSAGE"],
                    "NAME" => $arResult["BEFORE_ERROR_NAME"]
                ];

        // get item's data
        if (!empty($arParams['ID'])) {
            $this->data = $this->getData();

            if (!$this->data)
                $arErrors[] = [
                    "NAME" => 'SYSTEM',
                    "MESSAGE" => Loc::getMessage('ERROR_GET_DATA'),
                ];
            else
                $arResult['DATA'] = $this->data;
        }

        $this->setAdditionalFiles();

        $arSuccess = [
            'SUCCESS' => [
                0 => [
                    'NAME' => 'SYSTEM',
                    'MESSAGE' => $arParams['SUCCESS_MESSAGE']
                ],
            ],
        ];

        // form is submited
        if (!empty($_REQUEST['FORM_' . $arParams['ID_FORM']])) {

            if (!defined('PUBLIC_AJAX_MODE'))
                define('PUBLIC_AJAX_MODE', true);

            if (!check_bitrix_sessid())
                $arErrors[] = [
                    'NAME' => 'BITRIX_SESSID',
                    'MESSAGE' => Loc::getMessage('ERROR_BITRIX_SESSID'),
                ];

            // validation
            $arRules = $this->getRules();
            $rsValid = $obForm->doValidation(array_merge($_REQUEST, $_FILES), $arRules);
            if (!$rsValid)
                $arErrors = array_merge($arErrors, $obForm->errors);

            // save
            if (empty($arErrors)) {
                $el = new \CIBlockElement;
                $arFields = $this->prepareFields();

                if (!empty($arResult['DATA']['ID'])) {
                    if ($el->update($arResult['DATA']['ID'], $arFields))
                        $idElem = $arResult['DATA']['ID'];
                } else {
                    $arFields['CODE'] = \CUtil::translit($arFields['NAME'], "ru", $params);
                    $idElem = $el->Add($arFields);
                }

                if ($idElem) {

                    // send admin notification
                    if ($arParams["ADMIN_NOTIFICATION"] == "Y") {
                        $arSite = \CSite::GetList($by = "sort", $order = "desc", ["ID" => SITE_ID])->fetch();
                        if (!empty($arSite["EMAIL"]))
                            \CEvent::Send("TB_FORMS_ADMIN_NOTIFICATION", SITE_ID, ["TEXT" => $arFields['FULL_TEXT']]);
                    }

                    $this->arParams['ID'] = $idElem;
                    $this->data = $this->getData();

                    $arResult = $arSuccess;
                } else {
                    $arErrors[] = [
                        "MESSAGE" => htmlspecialchars($el->LAST_ERROR),
                        "NAME" => "SYSTEM"
                    ];
                }
            }
        }

        if (!empty($arErrors))
            $arResult['ERRORS'] = $arErrors;

        $arResult['FILER_CAPTIONS'] = $this->getFilerCaptions();
        $arResult['DATA'] = $this->data;

        // check after events
        foreach (\GetModuleEvents('tb.forms', 'OnAfterProcessing', true) as $arEvent)
            \ExecuteModuleEventEx($arEvent, array(&$_REQUEST, &$arParams, &$arResult));

        // form is submited
        if (!empty($_REQUEST['FORM_' . $arParams['ID_FORM']])) {

            $arJsResult = $arResult;
            $arJsResult['ID'] = $arResult['DATA']['ID'];
            $arJsResult['FILES'] = $arResult['DATA']['FILES'];
            unset($arJsResult['DATA'], $arJsResult['FILER_CAPTIONS']);

            $response = '<script>';
            $response .= "window.parent.TbFormOnResponse('FORM_" . $arParams['ID_FORM'] . "', '" . Json::encode($arJsResult) . "');";
            $response .= '</script>';

            $APPLICATION->RestartBuffer();
            die($response);
        }

        $this->arResult = $arResult;
        $this->includeComponentTemplate();

        return true;
    }

    public function getData()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            return false;

        $arParams = $this->arParams;
        $arItem = [];

        if (empty($arParams['ID']))
            return false;

        $obItem = \CIBlockElement::GetList([], ['ID' => $arParams['ID']])->getNextElement();

        if (!$obItem)
            return false;

        $arItem = $obItem->getFields();
        $arItem['PROPERTIES'] = $obItem->getProperties();

        // files
        for ($i = 1; $i <= $arParams["CTN_FIELDS"]; $i++) {

            // is it field?
            if (in_array($arParams['FIELD_SAVE_' . $i], ['PREVIEW_PICTURE', 'DETAIL_PICTURE'])) {
                $arTmp = \CFile::GetById($arItem[$arParams['FIELD_SAVE_' . $i]])->fetch();

                if ($arTmp)
                    $arItem['FILES'][$arParams['FIELD_CODE_' . $i]] = [
                        'CODE' => $arParams['FIELD_CODE_' . $i],
                        'ID_DOM_ELEMENT' => $arParams['ID_FORM'] . '_' . $arParams['FIELD_CODE_' . $i],
                        'FILER' => [
                            0 => [
                                'name' => $arTmp['ORIGINAL_NAME'],
                                'size' => $arTmp['FILE_SIZE'],
                                'type' => $arTmp['CONTENT_TYPE'],
                                'file' => '/upload/' . $arTmp['SUBDIR'] . '/' . $arTmp['FILE_NAME'],
                                'url' => '/upload/' . $arTmp['SUBDIR'] . '/' . $arTmp['FILE_NAME'],
                                'propValId' => $arItem[$arParams['FIELD_SAVE_' . $i]]
                            ]
                        ]
                    ];
            }

            // is it property?
            if ($arParams['FIELD_TYPE_' . $i] == 'file' && strstr($arParams['FIELD_SAVE_' . $i], 'PROPERTY_')) {

                if (is_array($arItem['PROPERTIES'][str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])]['VALUE'])) {
                    $arPropValIds = $arItem['PROPERTIES'][str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])]['PROPERTY_VALUE_ID'];
                    $arValues = $arItem['PROPERTIES'][str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])]['VALUE'];
                } else {
                    $arPropValIds = [
                        0 => $arItem['PROPERTIES'][str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])]['PROPERTY_VALUE_ID']
                    ];
                    $arValues = [
                        0 => $arItem['PROPERTIES'][str_replace('PROPERTY_', '', $arParams['FIELD_SAVE_' . $i])]['VALUE']
                    ];
                }

                foreach ($arValues as $fKey => $fVal) {
                    $arTmp = \CFile::GetById($fVal)->fetch();

                    if ($arTmp) {
                        if (empty($arItem['FILES'][$arParams['FIELD_CODE_' . $i]]))
                            $arItem['FILES'][$arParams['FIELD_CODE_' . $i]] = [
                                'CODE' => $arParams['FIELD_CODE_' . $i],
                                'ID_DOM_ELEMENT' => $arParams['ID_FORM'] . '_' . $arParams['FIELD_CODE_' . $i],
                            ];

                        $arItem['FILES'][$arParams['FIELD_CODE_' . $i]]['FILER'][] = [
                            'name' => $arTmp['ORIGINAL_NAME'],
                            'size' => $arTmp['FILE_SIZE'],
                            'type' => $arTmp['CONTENT_TYPE'],
                            'file' => '/upload/' . $arTmp['SUBDIR'] . '/' . $arTmp['FILE_NAME'],
                            'url' => '/upload/' . $arTmp['SUBDIR'] . '/' . $arTmp['FILE_NAME'],
                            'propValId' => $arPropValIds[$fKey],
                        ];
                    }
                }
            }
        }

        return $arItem;
    }

    public function prepareFields()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            die('Error module include.');

        $arParams = $this->arParams;
        $arData = $this->data;
        $arFieldsIblock = [
            "NAME" => Loc::getMessage('FIELED_SAVE_NAME'),
            "PREVIEW_TEXT" => Loc::getMessage('FIELED_SAVE_PREVIEW_TEXT'),
            "DETAIL_TEXT" => Loc::getMessage('FIELED_SAVE_DETAIL_TEXT'),
        ];

        // properties
        if ($arParams["IBLOCK_ID"] > 0) {
            $rsProps = \CIBlockProperty::GetList(Array("SORT" => "DESC"), Array("IBLOCK_ID" => $arParams["IBLOCK_ID"]));
            while ($arProp = $rsProps->fetch())
                $arProps["PROPERTY_" . $arProp["CODE"]] = $arProp;
        }

        $arFields = [
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "IBLOCK_SECTION_ID" => (!empty($arParams["IBLOCK_SECTION"])) ? $arParams["IBLOCK_SECTION"] : false,
        ];

        $fullText = '';
        for ($i = 1; $i <= $arParams["CTN_FIELDS"]; $i++) {

            // is it property?
            if (array_key_exists($arParams["FIELD_SAVE_" . $i], $arProps)) {

                $clearPropName = $arProps[$arParams["FIELD_SAVE_" . $i]]['CODE'];

                // is it file?
                if ($arParams["FIELD_TYPE_" . $i] == 'file') {

                    // delete old files
                    if (!empty($arData['PROPERTIES'][$clearPropName]['VALUE'])) {
                        $arPropertyValueId = is_array($arData['PROPERTIES'][$clearPropName]['PROPERTY_VALUE_ID']) ? $arData['PROPERTIES'][$clearPropName]['PROPERTY_VALUE_ID'] : [0 => $arData['PROPERTIES'][$clearPropName]['PROPERTY_VALUE_ID']];

                        foreach ($arPropertyValueId as $oldFilePropId)
                            if (in_array($oldFilePropId, $_REQUEST['DEL_FILE_PROPVALID']))
                                $arFields["PROPERTY_VALUES"][$clearPropName][$oldFilePropId] = [
                                    'VALUE' => [
                                        'del' => 'Y',
                                        'tmp_name' => '',
                                    ]
                                ];
                    }

                    // add new files
                    foreach ($_FILES[$arParams["FIELD_CODE_" . $i]]["name"] as $fKey => $fVal) {

                        if (empty($fVal))
                            continue;

                        $arFields["PROPERTY_VALUES"][$clearPropName][] = [
                            'VALUE' => [
                                'name' => $_FILES[$arParams["FIELD_CODE_" . $i]]["name"][$fKey],
                                'size' => $_FILES[$arParams["FIELD_CODE_" . $i]]["size"][$fKey],
                                'tmp_name' => $_FILES[$arParams["FIELD_CODE_" . $i]]["tmp_name"][$fKey],
                                'type' => $_FILES[$arParams["FIELD_CODE_" . $i]]["type"][$fKey],
                            ],
                            'DESCRIPTION' => $_FILES[$arParams["FIELD_CODE_" . $i]]["name"][$fKey],
                        ];
                    }

                    continue;
                }

                switch ($arProps[$arParams["FIELD_SAVE_" . $i]]["USER_TYPE"]) {

                    // html type
                    case 'HTML':

                        $arFields["PROPERTY_VALUES"][$clearPropName] = [
                            "VALUE" => [
                                "TEXT" => $_REQUEST[$arParams["FIELD_CODE_" . $i]],
                                "TYPE" => "text"
                            ]
                        ];

                        $fullText .= $_REQUEST[$arParams["FIELD_CODE_" . $i]] . PHP_EOL;

                        break;

                    // link to element
                    case 'E':

                        $arFields["PROPERTY_VALUES"][$clearPropName] = $_REQUEST[$arParams["FIELD_CODE_" . $i]];
                        $arTmp = \CIBlockElement::GetByID($_REQUEST[$arParams["FIELD_CODE_" . $i]])->fetch();
                        if ($arTmp)
                            $fullText .= $arProps[$arParams["FIELD_SAVE_" . $i]]["NAME"] . ": " . $arTmp["NAME"] . PHP_EOL;

                        break;

                    default:
                        $arFields["PROPERTY_VALUES"][$clearPropName] = $_REQUEST[$arParams["FIELD_CODE_" . $i]];
                        $fullText .= $arProps[$arParams["FIELD_SAVE_" . $i]]["NAME"] . ": " . $_REQUEST[$arParams["FIELD_CODE_" . $i]] . PHP_EOL;

                        break;
                }

                continue;
            }

            // is it file?
            if ($arParams["FIELD_TYPE_" . $i] == 'file') {

                if (!array_key_exists($arParams["FIELD_CODE_" . $i], $_FILES) || empty($_FILES[$arParams["FIELD_CODE_" . $i]]['name'][0])) {

                    if (in_array($arData[$arParams["FIELD_SAVE_" . $i]], $_REQUEST['DEL_FILE_PROPVALID']))
                        $arFields[$arParams["FIELD_SAVE_" . $i]]['del'] = 'Y';

                    continue;
                }

                if (in_array($arParams["FIELD_SAVE_" . $i], ['PREVIEW_PICTURE', 'DETAIL_PICTURE']))
                    $arFields[$arParams["FIELD_SAVE_" . $i]] = [
                        'name' => $_FILES[$arParams["FIELD_CODE_" . $i]]['name'][0],
                        'size' => $_FILES[$arParams["FIELD_CODE_" . $i]]['size'][0],
                        'tmp_name' => $_FILES[$arParams["FIELD_CODE_" . $i]]['tmp_name'][0],
                        'type' => $_FILES[$arParams["FIELD_CODE_" . $i]]['type'][0],
                    ];

                continue;
            }

            // is it field?
            $arFields[$arParams["FIELD_SAVE_" . $i]] = $_REQUEST[$arParams["FIELD_CODE_" . $i]];
            $fullText .= $arFieldsIblock[$arParams["FIELD_SAVE_" . $i]] . ": " . $_REQUEST[$arParams["FIELD_CODE_" . $i]] . PHP_EOL;
        }

        if ($arParams['REWRITE_DETAIL_TEXT'] == 'N')
            $arFields['DETAIL_TEXT'] = $fullText;

        if (empty($arFields["NAME"]))
            $arFields["NAME"] = "Unknown";

        $arFields['FULL_TEXT'] = $fullText;

        return $arFields;
    }

    public function setAdditionalFiles()
    {
        $arParams = $this->arParams;

        $asset = Asset::getInstance();

        $asset->addJs($this->getPath() . '/assets/js/script.js');

        if ($arParams['ADD_JQUERY'] == 'Y')
            $asset->addJs($this->getPath() . '/assets/js/jquery-3.4.1.min.js');

        if ($arParams["ADD_MASKEDINPUT"] == "Y")
            $asset->addJs($this->getPath() . '/assets/js/jquery.maskedinput.js');

        if ($arParams["ADD_BOOTSTRAP"] == "Y") {
            $asset->addJs($this->getPath() . '/assets/bootstrap/js/bootstrap.min.js');
            $asset->addCss($this->getPath() . '/assets/bootstrap/css/bootstrap.min.css');
        }

        if ($arParams['ADD_JQUERY_FILER'] == 'Y') {
            $asset->addCss($this->getPath() . '/assets/jQuery.filer/css/jquery.filer.css');
            $asset->addCss($this->getPath() . '/assets/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css');
            $asset->addJs($this->getPath() . '/assets/jQuery.filer/js/jquery.filer.min.js');
        }

        if (!IsModuleInstalled('tb.shop'))
            $asset->addJs($this->getPath() . '/assets/js/additional.js');

        return true;
    }

    public function getRules()
    {
        $arParams = $this->arParams;
        $arResult = [];

        for ($i = 1; $i <= $arParams["CTN_FIELDS"]; $i++) {

            // required
            if ($arParams["FIELD_REQUIRED_" . $i] == "Y") {
                $arResult["RULES"][$arParams["FIELD_CODE_" . $i]]["required"] = true;
                if (!empty($arParams["FIELD_ERROR_" . $i]))
                    $arResult["MESSAGES"][$arParams["FIELD_CODE_" . $i]]["required"] = $arParams["FIELD_ERROR_" . $i];
                else
                    $arResult["MESSAGES"][$arParams["FIELD_CODE_" . $i]]["required"] = GetMessage("TB_FORMS_ERROR_FIELD") . ' "' . $arParams["FIELD_NAME_" . $i] . '".';
            }

            // email
            if ($arParams["FIELD_TYPE_" . $i] == "email") {
                $arResult["RULES"][$arParams["FIELD_CODE_" . $i]]["email"] = true;
                if (!empty($arParams["FIELD_ERROR_" . $i]))
                    $arResult["MESSAGES"][$arParams["FIELD_CODE_" . $i]]["email"] = $arParams["FIELD_ERROR_" . $i];
                else
                    $arResult["MESSAGES"][$arParams["FIELD_CODE_" . $i]]["email"] = GetMessage("TB_FORMS_ERROR_FIELD") . ' "' . $arParams["FIELD_NAME_" . $i] . '".';
            }
        }

        return $arResult;
    }

    public function getFilerCaptions()
    {
        $arResult = [
            'button' => Loc::getMessage('FILER_BUTTON'),
            'feedback' => Loc::getMessage('FILER_FEEDBACK'),
            'feedback2' => Loc::getMessage('FILER_FEEDBACK2'),
            'drop' => Loc::getMessage('FILER_DROP'),
            'removeConfirmation' => Loc::getMessage('FILER_REMOVE_CONFIRMATION'),
            'errors' => [
                'filesLimit' => Loc::getMessage('FILER_FILES_LIMIT'),
                'filesType' => Loc::getMessage('FILER_FILES_TYPE'),
                'filesSize' => Loc::getMessage('FILER_FILES_SIZE'),
                'filesSizeAll' => Loc::getMessage('FILER_FILES_SIZE_ALL'),
                'folderUpload' => Loc::getMessage('FILER_FOLDER_UPLOAD'),
            ]
        ];

        return $arResult;
    }

}

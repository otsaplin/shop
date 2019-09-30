<?php

namespace TB\Forms;

class Main
{
    
    var $errors = [];

    public function doValidation($arFields, $arRules, $arParams = ["ONE_ERROR" => false])
    {

        global $APPLICATION;
        $arErrors = [];

        foreach ($arRules["RULES"] as $key => $arRule) {
            foreach ($arRule as $subKey => $subRule) {
                $tmpError = false;

                switch ($subKey) {
                    case "required":
                        if (is_array($arFields[$key]) && $subRule) {
                            foreach ($arFields[$key] as $itemKey => $item)
                                if (empty($item)) {
                                    $arErrors[] = [
                                        "NAME" => $key . '[' . $itemKey . ']',
                                        "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error " . $key
                                    ];

                                    $tmpError = true;
                                }
                        } else if (empty($arFields[$key]) && $subRule) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error " . $key
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "email":
                        if (!empty($arFields[$key]) && is_array($arFields[$key])) {
                            foreach ($arFields[$key] as $itemKey => $item)
                                if (!filter_var($item, FILTER_VALIDATE_EMAIL) && !empty($item)) {
                                    $arErrors[] = [
                                        "NAME" => $key . '[' . $itemKey . ']',
                                        "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error e-mail"
                                    ];

                                    $tmpError = true;
                                }
                        } else if (!filter_var($arFields[$key], FILTER_VALIDATE_EMAIL) && !empty($arFields[$key])) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error e-mail"
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "url":
                        if (!filter_var($arFields[$key], FILTER_VALIDATE_URL) && !empty($arFields[$key])) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error url"
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "digits":
                        if (is_array($arFields[$key]) && $subRule) {
                            foreach ($arFields[$key] as $itemKey => $item)
                                if (!preg_match('/^[0-9]+$/i', $item) && !empty($item)) {
                                    $arErrors[] = [
                                        "NAME" => $key . '[' . $itemKey . ']',
                                        "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error digits " . $key
                                    ];

                                    $tmpError = true;
                                }
                        } else if (!preg_match('/^[0-9]+$/i', $arFields[$key]) && !empty($arFields[$key]) && $subRule) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error digits " . $key
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "max":
                        if (intval($arFields[$key]) > $subRule && !empty($arFields[$key])) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error max " . $key
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "min":
                        if (intval($arFields[$key]) < $subRule && !empty($arFields[$key])) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error max " . $key
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "rangelength":
                        if ($arParams["INPUT_UTF8"])
                            $tmpStr = $APPLICATION->ConvertCharset($arFields[$key], 'UTF-8', SITE_CHARSET);
                        else
                            $tmpStr = $arFields[$key];
                        if ((strlen($tmpStr) < $subRule[0] || strlen($tmpStr) > $subRule[1]) && !empty($tmpStr)) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error rangelength "
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "maxlength":
                        if ($arParams["INPUT_UTF8"])
                            $tmpStr = $APPLICATION->ConvertCharset($arFields[$key], 'UTF-8', SITE_CHARSET);
                        else
                            $tmpStr = $arFields[$key];
                        if (strlen($tmpStr) > $subRule && !empty($tmpStr)) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error maxlength"
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "minlength":
                        if ($arParams["INPUT_UTF8"])
                            $tmpStr = $APPLICATION->ConvertCharset($arFields[$key], 'UTF-8', SITE_CHARSET);
                        else
                            $tmpStr = $arFields[$key];
                        if (strlen($tmpStr) < $subRule && !empty($tmpStr)) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error minlength"
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "link_fields":
                        $flag = false;
                        foreach ($subRule as $nameField) {
                            if (!empty($arFields[$nameField]))
                                $flag = true;
                        }
                        if (!$flag) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error link"
                            ];

                            $tmpError = true;
                        }
                        break;
                    case "pattern":
                        if (!preg_match($subRule, $arFields[$key]) && !empty($arFields[$key])) {
                            $arErrors[] = [
                                "NAME" => $key,
                                "MESSAGE" => !empty($arRules["MESSAGES"][$key][$subKey]) ? $arRules["MESSAGES"][$key][$subKey] : "Error pattern"
                            ];

                            $tmpError = true;
                        }
                        break;
                }

                if ($tmpError && $arParams["ONE_ERROR"])
                    break;
            }
        }

        if (!empty($arErrors)) {
            
            $this->errors = array_merge($this->errors, $arErrors);
            
            return false;
        } else
            return true;
    }

}

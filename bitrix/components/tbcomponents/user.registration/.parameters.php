<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arFields = [
    'LOGIN' => GetMessage("FIELD_LOGIN"),
    'EMAIL' => GetMessage("FIELD_EMAIL"),
    'PERSONAL_PHONE' => GetMessage("FIELD_PERSONAL_PHONE"),
    'NAME' => GetMessage("FIELD_NAME"),
    'SECOND_NAME' => GetMessage("FIELD_SECOND_NAME"),
    'LAST_NAME' => GetMessage("FIELD_LAST_NAME"),
    'FIO' => GetMessage("FIELD_FIO"),
    'PERSONAL_PROFESSION' => GetMessage("FIELD_PERSONAL_PROFESSION"),
    'PERSONAL_WWW' => GetMessage("FIELD_PERSONAL_WWW"),
    'PERSONAL_GENDER' => GetMessage("FIELD_PERSONAL_GENDER"),
    'PERSONAL_BIRTHDAY' => GetMessage("FIELD_PERSONAL_BIRTHDAY"),
    'PERSONAL_CITY' => GetMessage("FIELD_PERSONAL_CITY"),
    'PERSONAL_COUNTRY' => GetMessage("FIELD_PERSONAL_COUNTRY"),
    'PERSONAL_ZIP' => GetMessage("FIELD_PERSONAL_ZIP"),
    'PERSONAL_STREET' => GetMessage("FIELD_PERSONAL_STREET"),
    'WORK_COMPANY' => GetMessage("FIELD_WORK_COMPANY"),
    'WORK_DEPARTMENT' => GetMessage("FIELD_WORK_DEPARTMENT"),
    'WORK_POSITION' => GetMessage("FIELD_WORK_POSITION"),
    'WORK_WWW' => GetMessage("FIELD_WORK_WWW"),
    'WORK_PHONE' => GetMessage("FIELD_WORK_PHONE"),
    'PASSWORD' => GetMessage("FIELD_PASSWORD"),
    'CONFIRM_PASSWORD' => GetMessage("FIELD_CONFIRM_PASSWORD"),
];

$arComponentParameters = [
    'PARAMETERS' => [
        'FORM_ID' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("FORM_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ],
        'SHOW_FIELDS' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("SHOW_FIELDS"),
            "TYPE" => "LIST",
            "DEFAULT" => "",
            "REFRESH" => "N",
            "MULTIPLE" => "Y",
            "VALUES" => $arFields,
        ],
        'REQUIRED_FIELDS' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("REQUIRED_FIELDS"),
            "TYPE" => "LIST",
            "DEFAULT" => "",
            "REFRESH" => "N",
            "MULTIPLE" => "Y",
            "VALUES" => $arFields,
        ],
        'AUTH_AFTER_REG' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("AUTH_AFTER_REG"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        'REDIRECT_URL' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("REDIRECT_URL"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ],
        'USE_PRIVACY_POLICY' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("USE_PRIVACY_POLICY"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "REFRESH" => "N",
        ],
        'PRIVACY_POLICY_CHECKED' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("PRIVACY_POLICY_CHECKED"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "REFRESH" => "N",
        ],
        'PRIVACY_POLICY_TEXT' => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("PRIVACY_POLICY_TEXT"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ]
    ],
];

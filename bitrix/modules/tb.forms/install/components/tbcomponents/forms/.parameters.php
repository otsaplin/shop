<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\Bitrix\Main\Loader::includeModule('iblock');

$arIblockType = [];
$arIblockIds = [];

// iblock's types
$dbIBlockType = \CIBlockType::GetList(["sort" => "asc"], ["ACTIVE" => "Y"]);
while ($arIBlockType = $dbIBlockType->Fetch()) {
    if ($arIBlockTypeLang = \CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID)) {
        $arIblockType[$arIBlockType["ID"]] = "[" . $arIBlockType["ID"] . "] " . $arIBlockTypeLang["NAME"];
    }
}

// iblocks
$arFilter = ["ACTIVE" => "Y"];
if (!empty($arCurrentValues["IBLOCK_TYPE"]))
    $arFilter["TYPE"] = $arCurrentValues["IBLOCK_TYPE"];
$rsIblocks = \CIBlock::GetList(["SORT" => "ASC"], $arFilter);
while ($arIblock = $rsIblocks->fetch()) {
    $arIblockIds[$arIblock["ID"]] = "[" . $arIblock["ID"] . "] " . $arIblock["NAME"];
}

$arComponentParameters = [
    "GROUPS" => [
        "SETTINGS_FIELDS" => [
            "NAME" => GetMessage("SETTINGS_FIELDS"),
            "SORT" => 800
        ],
    ],
    "PARAMETERS" => [
        "ID_FORM" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ID_FORM"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
        ],
        "ADD_JQUERY" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ADD_JQUERY"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "ADD_BOOTSTRAP" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ADD_BOOTSTRAP"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "ADD_MASKEDINPUT" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ADD_MASKEDINPUT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "ADD_JQUERY_FILER" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ADD_JQUERY_FILER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "REWRITE_DETAIL_TEXT" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("REWRITE_DETAIL_TEXT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "ADMIN_NOTIFICATION" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("ADMIN_NOTIFICATION"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "REFRESH" => "N",
        ],
        "USE_CAPTCHA" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("USE_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "N",
        ],
        "IBLOCK_TYPE" => [
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "DEFAULT" => "",
            "REFRESH" => "Y",
            "VALUES" => $arIblockType
        ],
        "IBLOCK_ID" => [
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("IBLOCK_ID"),
            "TYPE" => "LIST",
            "DEFAULT" => "",
            "REFRESH" => "Y",
            "VALUES" => $arIblockIds
        ],
    ]
];

// sections
if ($arCurrentValues["IBLOCK_ID"] > 0) {
    $arIblockSections = [];
    $rsSections = \CIBlockSection::GetList(["SORT" => "ASC"], ["ACTIVE" => "Y", "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]]);
    while ($arSection = $rsSections->fetch()) {
        $arIblockSections[$arSection["ID"]] = $arSection["NAME"];
    }
    if (!empty($arIblockSections)) {
        $arIblockSections[0] = GetMessage("IBLOCK_SECTION_EMPTY");
        $arComponentParameters["PARAMETERS"]["IBLOCK_SECTION"] = [
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("IBLOCK_SECTION"),
            "TYPE" => "LIST",
            "DEFAULT" => 0,
            "REFRESH" => "N",
            "VALUES" => $arIblockSections
        ];
    }
}

$CTN_FIELDS = (!empty($arCurrentValues["CTN_FIELDS"])) ? $arCurrentValues["CTN_FIELDS"] : 2;
$arComponentParameters["PARAMETERS"]["CTN_FIELDS"] = [
    "PARENT" => "SETTINGS_FIELDS",
    "NAME" => GetMessage("CTN_FIELDS"),
    "TYPE" => "LIST",
    "DEFAULT" => 2,
    "REFRESH" => "Y",
    "ADDITIONAL_VALUES" => "Y",
    "VALUES" => Array(1 => 1, 2 => 2, 3 => 3, 4 => 4)
];

$arFieldTypes = [
    "text" => "text",
    "phone" => "phone",
    "email" => "email",
    "password" => "password",
    "hidden" => "hidden",
    "file" => "file",
];

$arFieldSave = Array(
    "DETAIL_TEXT" => GetMessage("FIELED_SAVE_DETAIL_TEXT"),
    "NAME" => GetMessage("FIELED_SAVE_NAME"),
    "PREVIEW_TEXT" => GetMessage("FIELED_SAVE_PREVIEW_TEXT"),
);

// properties
if ($arCurrentValues["IBLOCK_ID"] > 0) {
    $rsProps = \CIBlockProperty::GetList(["SORT" => "DESC"], ["IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]]);
    while ($arProp = $rsProps->fetch())
        $arFieldSave["PROPERTY_" . $arProp["CODE"]] = "[" . $arProp["ID"] . "] " . $arProp["NAME"];
}

for ($i = 1; $i <= $CTN_FIELDS; $i++) {
    $arComponentParameters["GROUPS"]["SETTINGS_FIELD_" . $i] = [
        "NAME" => GetMessage("SETTINGS_FIELD") . " " . $i,
        "SORT" => 800 + $i
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_REQUIRED_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_REQUIRED"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "",
        "REFRESH" => "N",
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_NAME_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "REFRESH" => "N",
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_CODE_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_CODE"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "REFRESH" => "N",
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_TYPE_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_TYPE"),
        "TYPE" => "LIST",
        "DEFAULT" => "",
        "REFRESH" => "N",
        "VALUES" => $arFieldTypes
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_ERROR_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_ERROR"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "REFRESH" => "N",
    ];

    $arComponentParameters["PARAMETERS"]["FIELD_SAVE_" . $i] = [
        "PARENT" => "SETTINGS_FIELD_" . $i,
        "NAME" => GetMessage("FIELD_SAVE"),
        "TYPE" => "LIST",
        "DEFAULT" => "",
        "REFRESH" => "N",
        "VALUES" => $arFieldSave
    ];
}
?>
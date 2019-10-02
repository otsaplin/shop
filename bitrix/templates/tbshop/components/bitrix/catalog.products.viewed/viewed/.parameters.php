<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arTemplateParameters = [
    'MAX_NAME_LENGTH' => [
        'NAME' => GetMessage("MAX_NAME_LENGTH"),
        'PARENT' => 'CATALOG_PARAMS_1',
        'TYPE' => 'STRING',
        'DEFAULT' => '',
    ],
];
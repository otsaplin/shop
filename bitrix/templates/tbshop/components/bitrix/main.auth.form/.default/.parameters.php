<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arTemplateParameters = [
    'REDIRECT_URL' => [
        'NAME' => GetMessage("REDIRECT_URL"),
        'PARENT' => 'BASE',
        'TYPE' => 'STRING',
        'DEFAULT' => '',
    ],
];
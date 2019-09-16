<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if(!empty($_REQUEST['set_filter']))
    LocalRedirect($arResult['FILTER_URL']);
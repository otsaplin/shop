<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (!empty($_SESSION['ADD2BASKET'])) {
    global $APPLICATION;
    
    $arParams['ADDED_ITEM'] = $_SESSION['ADD2BASKET'];
    unset($_SESSION['ADD2BASKET']);

    $APPLICATION->RestartBuffer();

    $APPLICATION->IncludeComponent(
            "bitrix:sale.basket.basket", $templateName, $arParams
    );

    die();
}

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'ADD2BASKET') {
    $_SESSION['ADD2BASKET'] = $_REQUEST['id'];
}

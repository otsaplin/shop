<?php

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

Loc::loadMessages(__FILE__);

$asset = Asset::getInstance();

global $APPLICATION;
global $USER;
?>
<!doctype html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

        <?
        $asset->addCss(SITE_TEMPLATE_PATH . '/assets/bootstrap/css/bootstrap.min.css');
        $asset->addCss(SITE_TEMPLATE_PATH . '/assets/fontawesome/css/all.min.css');
        $asset->addCss(SITE_TEMPLATE_PATH . '/assets/slick/slick.css');
        $asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/styles.css');
        $asset->addCss('/include/template/css/custom.css');

        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery-3.4.1.min.js');
        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/popper.min.js');
        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/bootstrap/js/bootstrap.min.js');
        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/slick/slick.min.js');
        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/jquery.maskedinput.js');
        $asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/scripts.js');
        $asset->addJs('/include/template/js/custom.js');
        ?>

        <title><? $APPLICATION->ShowTitle(); ?></title>

        <? $APPLICATION->ShowHead(); ?>
    </head>
    <body>
        <? $APPLICATION->ShowPanel(); ?>

        <div class="wrap">

            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-6 d-none d-lg-block">
                            <?
                            $APPLICATION->IncludeComponent(
                                    "bitrix:menu", "top-menu", Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "top",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "top",
                                "USE_EXT" => "N"
                                    )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-lg-6">
                            <? if ($USER->isAuthorized()) { ?>
                            <? } else { ?>
                                <? if (Option::get('main', 'new_user_phone_auth', 'N') == 'Y') { ?>
                                    <ul class="top-header__menu float-right ul_clear">
                                        <li><a href="#" data-toggle="modal" data-target="#registration-modal"><i class="fas fa-user"></i> <?= Loc::getMessage('USER_DO_AUTH'); ?></a></li>
                                    </ul>
                                <? } else { ?>
                                    <ul class="top-header__menu float-right ul_clear">
                                        <li class="mr-2"><a href="#" data-toggle="modal" data-target="#auth-modal"><i class="far fa-user"></i> <?= Loc::getMessage('USER_AUTH'); ?></a></li>
                                        <li class="mr-2">|</li>
                                        <li><a href="#" data-toggle="modal" data-target="#registration-modal"><i class="fas fa-lock"></i> <?= Loc::getMessage('USER_REGISTRATION'); ?></a></li>
                                    </ul>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="middle-header">
                <div class="container">
                    <div class="header">
                        <div class="row">
                            <div class="col-8 col-md-4 col-lg-3">
                                <?
                                $APPLICATION->IncludeComponent(
                                        "bitrix:main.include", "", Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/header.logo.php"
                                        )
                                );
                                ?>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block">
                                <div class="fbutton mt-2">
                                    <form action="/search/" method="GET">
                                        <input type="text" class="form-control" name="q" autocomplete="off" placeholder="<?= Loc::getMessage('INPUT_SEARCH'); ?>" />
                                        <button type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="d-none d-md-block col-md-4 col-lg-3">
                                <div class="header__info">
                                    <?
                                    $APPLICATION->IncludeComponent(
                                            "bitrix:main.include", "", Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/header.phone.php"
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-4 col-lg-2" id="basket-header-wrap">
                                <?
                                $APPLICATION->IncludeComponent(
                                        "bitrix:sale.basket.basket", "header", Array(
                                    "ACTION_VARIABLE" => "basketAction",
                                    "ADDITIONAL_PICT_PROP_1" => "-",
                                    "ADDITIONAL_PICT_PROP_2" => "-",
                                    "AUTO_CALCULATION" => "Y",
                                    "BASKET_IMAGES_SCALING" => "adaptive",
                                    "COLUMNS_LIST_EXT" => array("PREVIEW_PICTURE", "DISCOUNT", "DELETE", "DELAY", "TYPE", "SUM"),
                                    "COLUMNS_LIST_MOBILE" => array("PREVIEW_PICTURE", "DISCOUNT", "DELETE", "DELAY", "TYPE", "SUM"),
                                    "COMPATIBLE_MODE" => "Y",
                                    "CORRECT_RATIO" => "Y",
                                    "DEFERRED_REFRESH" => "N",
                                    "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                                    "DISPLAY_MODE" => "extended",
                                    "EMPTY_BASKET_HINT_PATH" => "/",
                                    "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
                                    "GIFTS_CONVERT_CURRENCY" => "N",
                                    "GIFTS_HIDE_BLOCK_TITLE" => "N",
                                    "GIFTS_HIDE_NOT_AVAILABLE" => "N",
                                    "GIFTS_MESS_BTN_BUY" => "Выбрать",
                                    "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
                                    "GIFTS_PAGE_ELEMENT_COUNT" => "4",
                                    "GIFTS_PLACE" => "BOTTOM",
                                    "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
                                    "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                                    "GIFTS_SHOW_OLD_PRICE" => "N",
                                    "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
                                    "HIDE_COUPON" => "N",
                                    "LABEL_PROP" => array(),
                                    "OFFERS_PROPS" => array(),
                                    "PATH_TO_ORDER" => "/basket/",
                                    "PRICE_DISPLAY_MODE" => "Y",
                                    "PRICE_VAT_SHOW_VALUE" => "N",
                                    "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
                                    "QUANTITY_FLOAT" => "Y",
                                    "SET_TITLE" => "Y",
                                    "SHOW_DISCOUNT_PERCENT" => "Y",
                                    "SHOW_FILTER" => "N",
                                    "SHOW_RESTORE" => "N",
                                    "TEMPLATE_THEME" => "blue",
                                    "TOTAL_BLOCK_DISPLAY" => array("top"),
                                    "USE_DYNAMIC_SCROLL" => "Y",
                                    "USE_ENHANCED_ECOMMERCE" => "N",
                                    "USE_GIFTS" => "N",
                                    "USE_PREPAYMENT" => "N",
                                    "USE_PRICE_ANIMATION" => "Y"
                                        )
                                );
                                ?>
                            </div>
                            <div class="col-12 d-md-none mt-3">
                                <div class="header__info">
                                    <?
                                    $APPLICATION->IncludeComponent(
                                            "bitrix:main.include", "", Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/header.phone.php"
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 d-lg-none mt-3">
                                <div class="fbutton mt-2">
                                    <form action="/search/" method="GET">
                                        <input type="text" class="form-control" name="q" autocomplete="off" placeholder="<?= Loc::getMessage('INPUT_SEARCH'); ?>" />
                                        <button type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?
            global $arTbParams;
            $mainMenuType = !empty($arTbParams['MAIN_MENU_TYPE']) ? $arTbParams['MAIN_MENU_TYPE'] : 'TYPE_1';
            ?>
            <? if ($mainMenuType == 'TYPE_1') { ?>
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list", "main-menu", Array(
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COUNT_ELEMENTS" => "N",
                    "FILTER_NAME" => "",
                    "IBLOCK_ID" => "1",
                    "IBLOCK_TYPE" => "catalog",
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => array("", ""),
                    "SECTION_ID" => "",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array("", ""),
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "3",
                    "VIEW_MODE" => "LINE"
                        )
                );
                ?>
            <? } ?>
            <? if ($mainMenuType == 'TYPE_2') { ?>
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list", "custom-menu", Array(
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COUNT_ELEMENTS" => "N",
                    "FILTER_NAME" => "",
                    "IBLOCK_ID" => "5",
                    "IBLOCK_TYPE" => "service",
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => array("", ""),
                    "SECTION_ID" => "",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array("UF_LINK", ""),
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "3",
                    "VIEW_MODE" => "LINE"
                        )
                );
                ?>
            <? } ?>

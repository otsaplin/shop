<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $APPLICATION;
?>
<div class="container">
    <div class="row">
        <div class="filter-wrap col-3 d-none d-md-block">
            <div class="filter-block mt-5">
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list", "sidebar", Array(
                    "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                    "CACHE_FILTER" => $arParams['CACHE_FILTER'],
                    "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    "COUNT_ELEMENTS" => $arParams['SECTION_COUNT_ELEMENTS'],
                    "FILTER_NAME" => "sectionsFilter",
                    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => [],
                    "SECTION_ID" => "",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => [],
                    "SHOW_PARENT_NAME" => $arParams['SECTIONS_SHOW_PARENT_NAME'],
                    "TOP_DEPTH" => $arParams['SECTION_TOP_DEPTH'],
                    "VIEW_MODE" => "",
                    "CURRENT_SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
                    "CURRENT_SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
                        )
                );
                ?>
            </div>
        </div>

        <div class="col-12 col-md-9">
            <h1 class="mt-5">Каталог товаров</h1>

            <?
            $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb", "breadcrumb", Array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0"
                    )
            );
            ?>

            <?
            $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list", "catalog", Array(
                "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                "CACHE_FILTER" => $arParams['CACHE_FILTER'],
                "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                "CACHE_TIME" => $arParams['CACHE_TIME'],
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                "COUNT_ELEMENTS" => $arParams['SECTION_COUNT_ELEMENTS'],
                "FILTER_NAME" => "sectionsFilter",
                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => [],
                "SECTION_ID" => "",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => [],
                "SHOW_PARENT_NAME" => $arParams['SECTIONS_SHOW_PARENT_NAME'],
                "TOP_DEPTH" => "2",
                "VIEW_MODE" => "",
                    )
            );
            ?>
        </div>
    </div>
</div>
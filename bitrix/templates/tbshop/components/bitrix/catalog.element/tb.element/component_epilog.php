<?

use \Bitrix\Catalog\CatalogViewedProductTable;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

CModule::IncludeModule("sale");

CatalogViewedProductTable::refresh($arResult['ID'], \CSaleBasket::GetBasketUserID());
/*
  ?>
  <? if (!empty($arResult['SYSTEM_RECOMMEND_ITEMS'])) { ?>
  <? $this->__parent->__template->SetViewTarget('RECOMMEND_ITEMS'); ?>
  <?

  global $arRecommend;
  $arRecommend['ID'] = $arResult['SYSTEM_RECOMMEND_ITEMS']['VALUE'];
  ?>
  <?

  $APPLICATION->IncludeComponent(
  "bitrix:catalog.section", "recommend", array(
  "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
  "IBLOCK_ID" => $arParams["IBLOCK_ID"],
  "ELEMENT_SORT_FIELD" => "sort",
  "ELEMENT_SORT_ORDER" => "asc",
  "ELEMENT_SORT_FIELD2" => "id",
  "ELEMENT_SORT_ORDER2" => "desc",
  "PROPERTY_CODE" => ["SYSTEM_IMAGES"],
  "PROPERTY_CODE_MOBILE" => "",
  "META_KEYWORDS" => "",
  "META_DESCRIPTION" => "",
  "BROWSER_TITLE" => "N",
  "SET_LAST_MODIFIED" => "N",
  "INCLUDE_SUBSECTIONS" => "Y",
  "BASKET_URL" => $arParams["BASKET_URL"],
  "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
  "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
  "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
  "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
  "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
  "FILTER_NAME" => "arRecommend",
  "CACHE_TYPE" => $arParams["CACHE_TYPE"],
  "CACHE_TIME" => $arParams["CACHE_TIME"],
  "CACHE_FILTER" => $arParams["CACHE_FILTER"],
  "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
  "SET_TITLE" => "N",
  "MESSAGE_404" => "",
  "SET_STATUS_404" => "N",
  "SHOW_404" => "N",
  "FILE_404" => "",
  "DISPLAY_COMPARE" => "N",
  "PAGE_ELEMENT_COUNT" => "2",
  "LINE_ELEMENT_COUNT" => "2",
  "PRICE_CODE" => $arParams["PRICE_CODE"],
  "USE_PRICE_COUNT" => "N",
  "SHOW_PRICE_COUNT" => "1",
  "PRICE_VAT_INCLUDE" => "Y",
  "USE_PRODUCT_QUANTITY" => "Y",
  "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
  "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
  "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),
  "DISPLAY_TOP_PAGER" => "N",
  "DISPLAY_BOTTOM_PAGER" => "N",
  "PAGER_TITLE" => "N",
  "PAGER_SHOW_ALWAYS" => "N",
  "PAGER_TEMPLATE" => "",
  "PAGER_DESC_NUMBERING" => "N",
  "PAGER_DESC_NUMBERING_CACHE_TIME" => "",
  "PAGER_SHOW_ALL" => "",
  "PAGER_BASE_LINK_ENABLE" => "N",
  "PAGER_BASE_LINK" => "",
  "PAGER_PARAMS_NAME" => "",
  "LAZY_LOAD" => "",
  "MESS_BTN_LAZY_LOAD" => "",
  "LOAD_ON_SCROLL" => "N",
  "OFFERS_CART_PROPERTIES" => "",
  "OFFERS_FIELD_CODE" => "",
  "OFFERS_PROPERTY_CODE" => "",
  "OFFERS_SORT_FIELD" => "",
  "OFFERS_SORT_ORDER" => "",
  "OFFERS_SORT_FIELD2" => "",
  "OFFERS_SORT_ORDER2" => "",
  "OFFERS_LIMIT" => "",
  "SECTION_ID" => "",
  "SECTION_CODE" => "",
  "SECTION_URL" => "",
  "DETAIL_URL" => "",
  "USE_MAIN_ELEMENT_SECTION" => "Y",
  'CONVERT_CURRENCY' => "",
  'CURRENCY_ID' => "",
  'HIDE_NOT_AVAILABLE' => "N",
  'HIDE_NOT_AVAILABLE_OFFERS' => "N",
  'LABEL_PROP' => "",
  'LABEL_PROP_MOBILE' => "",
  'LABEL_PROP_POSITION' => "",
  'ADD_PICT_PROP' => "",
  'PRODUCT_DISPLAY_MODE' => "",
  'PRODUCT_BLOCKS_ORDER' => "",
  'PRODUCT_ROW_VARIANTS' => "",
  'ENLARGE_PRODUCT' => "",
  'ENLARGE_PROP' => "",
  'SHOW_SLIDER' => "",
  'SLIDER_INTERVAL' => "",
  'SLIDER_PROGRESS' => "",
  'OFFER_ADD_PICT_PROP' => "",
  'OFFER_TREE_PROPS' => "",
  'PRODUCT_SUBSCRIPTION' => "N",
  'SHOW_DISCOUNT_PERCENT' => "Y",
  'DISCOUNT_PERCENT_POSITION' => "",
  'SHOW_OLD_PRICE' => "Y",
  'SHOW_MAX_QUANTITY' => "",
  'MESS_SHOW_MAX_QUANTITY' => "",
  'RELATIVE_QUANTITY_FACTOR' => "",
  'MESS_RELATIVE_QUANTITY_MANY' => "",
  'MESS_RELATIVE_QUANTITY_FEW' => "",
  'MESS_BTN_BUY' => "",
  'MESS_BTN_ADD_TO_BASKET' => "",
  'MESS_BTN_SUBSCRIBE' => "",
  'MESS_BTN_DETAIL' => "",
  'MESS_NOT_AVAILABLE' => "",
  'MESS_BTN_COMPARE' => "",
  'USE_ENHANCED_ECOMMERCE' => "",
  'DATA_LAYER_NAME' => "",
  'BRAND_PROPERTY' => "",
  'TEMPLATE_THEME' => "recommend",
  "ADD_SECTIONS_CHAIN" => "N",
  'ADD_TO_BASKET_ACTION' => "",
  'SHOW_CLOSE_POPUP' => "N",
  'COMPARE_PATH' => "",
  'COMPARE_NAME' => "",
  'USE_COMPARE_LIST' => 'Y',
  'BACKGROUND_IMAGE' => "",
  'COMPATIBLE_MODE' => "",
  'DISABLE_INIT_JS_IN_COMPONENT' => "",
  "SHOW_ALL_WO_SECTION" => "Y"
  ), false
  );
  ?>
  <? $this->__parent->__template->EndViewTarget(); ?>
  <? } ?>
  <?
 */
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>
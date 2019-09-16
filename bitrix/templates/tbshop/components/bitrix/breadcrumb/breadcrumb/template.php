<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$result = '';

if (!empty($arResult))
    $result .= '<ul class="breadcrumbs mt-3">';

foreach ($arResult as $key => $arItem) {
    $result .= '<li><a href="' . $arItem['LINK'] . '">' . $arItem['TITLE'] . '</a></li>';

    if (!empty($arResult[$key + 1]))
        $result .= '<li>/</li>';
}

if (!empty($arResult))
    $result .= '</ul>';

return $result;

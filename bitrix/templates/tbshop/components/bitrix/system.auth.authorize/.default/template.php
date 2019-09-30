<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<div class="container">
    <h1 class="mt-5"><?= Loc::getMessage('H1_TITLE'); ?></h1>

    <?
    $APPLICATION->IncludeComponent(
            "bitrix:breadcrumb", "breadcrumb", Array(
        "PATH" => "",
        "SITE_ID" => "s1",
        "START_FROM" => "0"
            )
    );
    ?>

    <div class="mt-5">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:main.include", "", Array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "/include/user.auth.php",
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>
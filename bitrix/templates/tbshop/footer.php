<?

use \Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

global $USER;
?>
<div class="footer__space"></div>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:menu", "footer-menu", Array(
                    "TITLE" => "Информация",
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "bottom1",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "bottom1",
                    "USE_EXT" => "N"
                        )
                );
                ?>
            </div>
            <div class="col-6 col-md-3">
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:menu", "footer-menu", Array(
                    "TITLE" => "Посетителям",
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "bottom2",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "bottom2",
                    "USE_EXT" => "N"
                        )
                );
                ?>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-lg-4 mt-3 mt-md-0 text-md-right">
                        <?
                        $APPLICATION->IncludeComponent(
                                "bitrix:main.include", "", Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/footer.socials.php"
                                )
                        );
                        ?>
                    </div>
                    <div class="col-12 col-lg-8 mt-3 mt-lg-0 text-md-right">
                        <div class="footer__title">Контакты</div>
                        <div class="mb-1_1">
                            <?
                            $APPLICATION->IncludeComponent(
                                    "bitrix:main.include", "", Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/footer.phone.php"
                                    )
                            );
                            ?>
                        </div>
                        <div>
                            <?
                            $APPLICATION->IncludeComponent(
                                    "bitrix:main.include", "", Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/footer.email.php"
                                    )
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <?
            $APPLICATION->IncludeComponent(
                    "bitrix:main.include", "", Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/include/footer.copyright.php"
                    )
            );
            ?>
        </div>
    </div>
</div>

</div>

<? // Basket modal  ?>
<div class="modal fade" id="basket-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Товар добавлен в корзину</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="mr-3" data-dismiss="modal">Продолжить покупки</a>
                <a href="/basket/" class="btn btn_red">Оформить заказ</a>
            </div>
        </div>
    </div>
</div>
<? // END Basket modal ?>

<? // Callback modal  ?>
<div class="modal fade" id="callback-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Заказать обратный звонок</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="px-5 py-4">
                    <?
                    $APPLICATION->IncludeComponent(
                            "bitrix:form.result.new", "flat", Array(
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CHAIN_ITEM_LINK" => "",
                        "CHAIN_ITEM_TEXT" => "",
                        "EDIT_URL" => "",
                        "IGNORE_CUSTOM_TEMPLATE" => "N",
                        "LIST_URL" => "",
                        "SEF_MODE" => "N",
                        "SUCCESS_URL" => "",
                        "USE_EXTENDED_ERRORS" => "Y",
                        "VARIABLE_ALIASES" => Array(
                            "RESULT_ID" => "RESULT_ID",
                            "WEB_FORM_ID" => "WEB_FORM_ID"
                        ),
                        "WEB_FORM_ID" => "2",
                        "ADD_MASKEDINPUT" => "N",
                        "SUCCESS_TEXT" => "Спасибо! В ближайшее время мы Вам перезвоним.",
                            )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? // END Callback modal ?>

<? // Auth modal ?>
<? if (!$USER->IsAuthorized()) { ?>
    <div class="modal fade" id="auth-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= Loc::getMessage('AUTH_MODAL'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="px-4 px-sm-5 py-4">
                        <?
                        $APPLICATION->IncludeComponent(
                                "bitrix:main.include", "", Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/user.auth.php",
                            "FORM_ID" => "AUTH_MODAL"
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<? // END Auth modal ?>

<? // Registration modal  ?>
<? if (!$USER->IsAuthorized()) { ?>
    <div class="modal fade" id="registration-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= Loc::getMessage('REGISTRATION_MODAL'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="px-4 px-sm-5 py-4">
                        <?
                        $APPLICATION->IncludeComponent(
                                "bitrix:main.include", "", Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/user.registration.php",
                            "FORM_ID" => "REG_MODAL"
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<? // End modal  ?>

</body>
</html>
<?

Class tb_forms extends CModule
{

    var $MODULE_ID = "tb.forms";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;

    function tb_forms()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");

        $path = substr($path, 0, strlen($path) - strlen("/install"));
        @include(GetLangFileName($path . "/lang/", "/install/index.php"));
        IncludeModuleLangFile($path . "/install/index.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = GetMessage("TB_FORMS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("TB_FORMS_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = GetMessage('TB_FORMS_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('TB_FORMS_MODULE_PARTNER_URI');
    }

    function InstallFiles()
    {
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        CopyDirFiles($path . "/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components", true, true);

        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/bitrix/components/tbcomponents/forms");

        return true;
    }

    function InstallLetters()
    {
        $rsType = \CEventType::GetList(Array("TYPE_ID" => "TB_FORMS_ADMIN_NOTIFICATION"));
        if (!$arType = $rsType->fetch()) {
            $et = new \CEventType;
            $et->Add(array(
                "LID" => "ru",
                "EVENT_NAME" => "TB_FORMS_ADMIN_NOTIFICATION",
                "NAME" => "TheBenefit: " . GetMessage("TB_FORMS_ADMIN_NOTIFICATION"),
                "DESCRIPTION" => "#TEXT# - " . GetMessage("TB_FORMS_ADMIN_NOTIFICATION_TXT"),
            ));
        }

        $rsMessage = \CEventMessage::GetList($by = 'id', $order = 'asc', Array("TYPE_ID" => "TB_FORMS_ADMIN_NOTIFICATION"));
        if (!$arMessage = $rsMessage->fetch()) {
            $arSites = Array();
            $rsSites = \CSite::GetList($by = 'sort', $order = 'asc');
            while ($arSite = $rsSites->fetch())
                $arSites[] = $arSite["ID"];
            
            $emess = new \CEventMessage;
            $emess->Add(Array(
                "ACTIVE" => "Y",
                "EVENT_NAME" => "TB_FORMS_ADMIN_NOTIFICATION",
                "LID" => $arSites,
                "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
                "EMAIL_TO" => "#DEFAULT_EMAIL_FROM#",
                "BCC" => "#BCC#",
                "SUBJECT" => "#SITE_NAME#: " . GetMessage("TB_FORMS_ADMIN_NOTIFICATION"),
                "BODY_TYPE" => "text",
                "MESSAGE" => "#TEXT#",
            ));
        }
        
        return true;
    }

    function UnIstallLetters()
    {
        $rsMessage = \CEventMessage::GetList($by = 'id', $order = 'asc', Array("TYPE_ID" => "TB_FORMS_ADMIN_NOTIFICATION"));
        if ($arMessage = $rsMessage->fetch()) {
            $emessage = new \CEventMessage;
            $emessage->Delete($arMessage["ID"]);
        }

        $rsType = \CEventType::GetList(Array("TYPE_ID" => "TB_FORMS_ADMIN_NOTIFICATION"));
        if ($arType = $rsType->fetch()) {
            $et = new \CEventType;
            $et->Delete("TB_FORMS_ADMIN_NOTIFICATION");
        }
    }

    function DoInstall()
    {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallLetters();
        RegisterModule($this->MODULE_ID);
    }

    function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallFiles();
        $this->UnIstallLetters();
        UnRegisterModule($this->MODULE_ID);
    }

}

?>
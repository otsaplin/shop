<?php

use Phinx\Migration\AbstractMigration;

class AddIblocksPrefix extends AbstractMigration
{

    public function up()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            return;

        global $arTbParams;

        $siteId = !empty($arTbParams['SITE_ID']) ? $arTbParams['SITE_ID'] : 's1';

        // iblock
        $check = \CIBlock::GetList([], ['CODE' => $siteId . '_mainmenu'])->fetch();

        if (!$check) {

            $ib = new \CIBlock;

            $arFields = [
                'ACTIVE' => 'Y',
                'NAME' => $siteId . ': Главное меню',
                'CODE' => $siteId . '_mainmenu',
                'IBLOCK_TYPE_ID' => 'service',
                'LID' => $siteId,
                'GROUP_ID' => ['2' => 'R'],
                'INDEX_ELEMENT' => 'N',
                'INDEX_SECTION' => 'N',
            ];

            $ID = $ib->Add($arFields);
        } else
            $ID = $check['ID'];

        if (empty($ID))
            return;

        // propery of element
        $checkProp = CIBlockProperty::GetList([], ['IBLOCK_ID' => $ID, 'CODE' => 'LINK'])->fetch();

        if (!$checkProp) {
            $ibp = new \CIBlockProperty;

            $arPropFields = [
                'CODE' => 'LINK',
                'IBLOCK_ID' => $ID,
                'NAME' => 'Ссылка',
                'ACTIVE' => 'Y',
                'PROPERTY_TYPE' => 'S',
            ];

            $ibp->Add($arPropFields);
        }

        // property of section
        $checkProp = CUserTypeEntity::GetList([], ['ENTITY_ID' => 'IBLOCK_' . $ID . '_SECTION', 'FIELD_NAME' => 'UF_LINK'])->fetch();

        if (!$checkProp) {

            $oUserTypeEntity = new \CUserTypeEntity();

            $aUserFields = [
                'ENTITY_ID' => 'IBLOCK_' . $ID . '_SECTION',
                'FIELD_NAME' => 'UF_LINK',
                'USER_TYPE_ID' => 'string',
                'MANDATORY' => 'N',
                'EDIT_IN_LIST' => '',
                'IS_SEARCHABLE' => 'N',
                'EDIT_FORM_LABEL' => [
                    'ru' => 'Ссылка',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru' => 'Ссылка',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru' => 'Ссылка',
                ],
            ];

            $oUserTypeEntity->add($aUserFields);
        }
    }

    public function down()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            return;

        global $arTbParams;

        $siteId = !empty($arTbParams['SITE_ID']) ? $arTbParams['SITE_ID'] : 's1';

        // iblock
        $check = \CIBlock::GetList([], ['CODE' => $siteId . '_mainmenu'])->fetch();
        if ($check) {
            $ID = $check['ID'];
            \CIBlock::Delete($ID);
        }

        // propery of element
        $checkProp = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $ID, 'CODE' => 'LINK'])->fetch();
        if ($checkProp)
            \CIBlockProperty::Delete($checkProp['ID']);

        // property of section
        $oUserTypeEntity = new \CUserTypeEntity();

        $checkProp = \CUserTypeEntity::GetList([], ['ENTITY_ID' => 'IBLOCK_' . $ID . '_SECTION', 'FIELD_NAME' => 'UF_LINK'])->fetch();
        if ($checkProp)
            $oUserTypeEntity->Delete($checkProp['ID']);
    }

}

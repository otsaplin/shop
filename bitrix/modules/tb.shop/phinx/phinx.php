<?php

define('NOT_CHECK_PERMISSIONS', true);
define('NO_AGENT_CHECK', true);

$GLOBALS['DBType'] = 'mysql';
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../../..');

include($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

// manual saving of DB resource
global $DB;

$app = \Bitrix\Main\Application::getInstance();
$con = $app->getConnection();
$DB->db_Conn = $con->getResource();

// 'authorizing' as admin
$_SESSION['SESS_AUTH']['USER_ID'] = 1;

$config = include realpath(__DIR__ . '/../../../.settings.php');

$host = ($config['connections']['value']['default']['host'] == 'localhost') ? '127.0.0.1' : $config['connections']['value']['default']['host'];

return array(
    'paths' => array(
        'migrations' => 'migrations'
    ),
    'environments' => array(
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => array(
            'adapter' => 'mysql',
            'host' => $host,
            'name' => $config['connections']['value']['default']['database'],
            'user' => $config['connections']['value']['default']['login'],
            'pass' => $config['connections']['value']['default']['password']
        )
    )
);

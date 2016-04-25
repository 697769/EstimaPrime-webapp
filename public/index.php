<?php

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library') . PATH_SEPARATOR .
    realpath(APPLICATION_PATH . '/models'),
    realpath(APPLICATION_PATH . '/modules/permission/models'),
    realpath(APPLICATION_PATH . '/modules/account/models'),
    realpath(APPLICATION_PATH . '/modules/marketing/models'),
    realpath(APPLICATION_PATH . '/modules/app/models'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
        APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini'
);

//Connect DataBase
$config = new Zend_Config_Ini('application/configs/application.ini', 'database');
$db = Zend_Db::factory($config->db->adapter, $config->db->config->toArray());
Zend_Db_Table_Abstract::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

$application->bootstrap()
        ->run();

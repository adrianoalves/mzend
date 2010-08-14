<?php
# taking in account that ZF is in PHP include path, we set main constants
defined('SEP')
    || define( 'SEP' , DIRECTORY_SEPARATOR );

# Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

# path to default view directory
defined( 'PATH_DEFAULT')
    || define( 'PATH_DEFAULT', APPLICATION_PATH.SEP.'views'.SEP );

# Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

/** Zend_Application */
require_once 'Zend/Application.php';  

# Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);

  $application->bootstrap()->run();
?>

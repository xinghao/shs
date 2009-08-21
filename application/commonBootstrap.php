<?php
/**
 * commonBootstrap.php
 * 
 * - Set up applications paths
 * - Set up logs
 * - Set up database pooling
 * - Set up memcached
 * - Set up routes
 * - Et cetera
 * 
 * This bootstrap file is used both for HTML entry point (index.php),
 * and for batch processing.
 *
 */
 
define('APPLICATION_PATH', realpath(dirname(__FILE__)));
define('WEBSITE_ROOT', realpath(dirname(__FILE__)) . '/../');

set_include_path(
	APPLICATION_PATH
    . PATH_SEPARATOR . APPLICATION_PATH . '/../library'
    . PATH_SEPARATOR . APPLICATION_PATH . '/../library/Hotspot'
	. PATH_SEPARATOR . APPLICATION_PATH . '/../library/Zend'
    . PATH_SEPARATOR . APPLICATION_PATH . '/models'
    . PATH_SEPARATOR . APPLICATION_PATH . '/models/tables'
    . PATH_SEPARATOR . APPLICATION_PATH . '/models/exceptions'
    . PATH_SEPARATOR . APPLICATION_PATH . '/views/helpers'
    . PATH_SEPARATOR . get_include_path()
);

error_reporting(E_ALL|E_STRICT);

date_default_timezone_set('Australia/Sydney');

require_once 'Hotspot/Log/LogWriter.php';
require_once 'Zend/Loader/Autoloader.php';

// Instantiate Zend Autoloader and keep instance in a variable
// We'll use the old autoloader (which will be deprecated in Zend 2.0) for now.
$loader = Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

/* TODO: Clean up namespaces for new Zend 1.8.1 Autoloader.
 * Keep these lines for the time being.
$loader->registerNamespace('CrFramework_');
$loader->registerNamespace('Common');
$loader->registerNamespace('Tag');
$loader->registerNamespace('Session');
$loader->registerNamespace('Timezone');
$loader->registerNamespace('SolrQuery');
$loader->registerNamespace('Apache');
$loader->registerNamespace('models');
*/

// load configuration
$environment	= new Zend_Config_Ini(APPLICATION_PATH.'/.environment');
defined('APPLICATION_ENVIRONMENT')
    or define('APPLICATION_ENVIRONMENT', $environment->env);

defined('LOG_DIR')
    or define('LOG_DIR', APPLICATION_PATH.'/../logs');

$config			= new Zend_Config_Ini(APPLICATION_PATH.'/config/config.ini', APPLICATION_ENVIRONMENT);
//$routes			= new Zend_Config_Ini(APPLICATION_PATH.'/config/routes/default.ini', APPLICATION_ENVIRONMENT);
//$seo			= new Zend_Config_Ini(APPLICATION_PATH.'/config/seo.ini', APPLICATION_ENVIRONMENT);
//$terms			= new Zend_Config_Ini(APPLICATION_PATH.'/config/terms.ini', APPLICATION_ENVIRONMENT);
//$acl			= new Zend_Config_Ini(APPLICATION_PATH.'/config/acl.ini', APPLICATION_ENVIRONMENT);


$registry = Zend_Registry::getInstance();
$registry->set('ENVIRONMENT', $environment);
$registry->set('CONFIG', $config);

// [xinghao] add template path.
$registry->set('TEMPLATINGSYSTEMPATH', WEBSITE_ROOT.'/templates');

defined('DEBUG')
	or define('DEBUG', $config->debug->messages);
ini_set('display_errors', $config->debug->messages);


// make sure we have logs available before doing anything else
$stdWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->std->location);
$stdLog		= new Zend_Log($stdWriter);
$errWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->err->location);
$errLog		= new Zend_Log($errWriter);

/*
//empty result
$emtpyWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->empty->page);
$stdEmtpy 		= new Zend_Log($emtpyWriter);

//statistic Acxiom
$adListingWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->adlistings->location);
$adListingLog		= new Zend_Log($adListingWriter);
$adDetailsWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->addetails->location);
$adDetailsLog		= new Zend_Log($adDetailsWriter);
*/
//debug
$debugWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->debug->location);
$debugLog		= new Zend_Log($debugWriter);

/*
// configure caching logger
$memcacheWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->memcache->location);
$memcacheLog    = new Zend_Log($memcacheWriter);

//log user
$usersWriter	= new Zend_Log_Writer_Stream(LOG_DIR.'/'.$config->log->users->location);
$userslog   	= new Zend_Log($usersWriter);
*/
//$formatter	= new Zend_Log_Formatter_Xml();
$format		= '%timestamp% %priorityName% (%priority%): %message%'.PHP_EOL;
$formatter	= new Zend_Log_Formatter_Simple($format);
$stdWriter->setFormatter($formatter);
$errWriter->setFormatter($formatter);
$debugWriter->setFormatter($formatter);

$firebugLog		= new Zend_Log();
$firebugWriter	= new Zend_Log_Writer_Firebug();
$firebugLog->addWriter($firebugWriter);

$registry->set('log_std', $stdLog);
$registry->set('log_err', $errLog);
$registry->set('log_fire', $firebugLog);
$registry->set('log_debug', $debugLog);


try {
	$db = Zend_Db::factory($config->db);
	//$db->getConnection();
	$registry->set('MyDB', $db);
	$db->query("SET NAMES 'utf8'");
	Zend_Registry::set('db', $db);
	// set this adapter as default for use with Zend_Db_Table
	Zend_Db_Table_Abstract::setDefaultAdapter($db);
} catch (Exception $e) {
	echo $e;
	logError('bootstrap', $e);
}


/*
try {
	Zend_Session::setOptions(array('gc_probability' => 1, 'gc_divisor' => 5000)); //clean if only 1 hit in every 5000
	Zend_Session::setSaveHandler(new Hotspot_Session_Handler($_cache));
} catch (Exception $e) {
	logStd('bootstrap', $e->getMessage());
}
*/

// set up controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(false);
$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');
$frontController->setParam('env', APPLICATION_ENVIRONMENT);

// set up custom routing for SEO
//$router = $frontController->getRouter();
//$router->addConfig($routes, 'routes');
//$frontController = Zend_Controller_Front::getInstance();
//$frontController->addModuleDirectory('../application/modules');
//$router = $frontController->getRouter();
$router = new Hotspot_Controller_Router_Rewrite();
$router->removeDefaultRoutes();
$frontController->setRouter($router);
$router->setRoutesDirectory(APPLICATION_PATH.'/config/routes', array(APPLICATION_ENVIRONMENT, 'routes'));

/*
$auth = Zend_Auth::getInstance();
$crAcl = new CrFramework_Acl($auth);
$frontController->setParam('auth', $auth);
$frontController->setParam('acl', $crAcl);
$frontController->registerPlugin(
	new CrFramework_Acl_Plugin($auth, $crAcl)
);
*/
//[xinghao]
//register 2 step view plugin

$frontController->registerPlugin(
	new Hotspot_Plugin_ViewSetup(),'Hotspot_Plugin_ViewSetup'
);

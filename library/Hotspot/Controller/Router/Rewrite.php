<?php
/**
 * CrFramework_Controller_Router_Rewrite
 * Extends Zend_Controller_Router_Rewrite
 * Provides custom routing based on the first level qualifier in the URI.
 * 
 * For URIs /app use controller route file eg. admin.ini
 * For all other URIs use default.ini
 * 
 * Created on Mar 24, 2009
 * 
 * [taz] Added a testing route facility that can be turned on and off
 * (e.g. on for development, off for production).
 * 
 * WARNING WILL ROBINSON: A route beginning with 'test' will get deleted 
 * from our routes unless the config.ini parameter debug.allow_test_routes = true.
 *   
 *      @version	$Id: Rewrite.php 5533 2009-07-08 13:56:57Z tasman $
 *      @package	CrFramework
 *      @subpackage	Controller
 *      @author		Tim Woo <tim@airarena.net>
 *      @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */

class Hotspot_Controller_Router_Rewrite extends Zend_Controller_Router_Rewrite
{
    /**
     * Routes directory
     * @var string
     */
    protected $_routesDirectory;
 
    /**
     * Set the path to the directory containing the routes
     *
     * @param string $path Path to the routes directory
     * @param array|null $sections Section name(s)
     * @return Zend_Controller_Router_Route_Interface Route object
     */
    public function setRoutesDirectory($path, $sections = null) 
    {
        $request = $this->getFrontController()->getRequest();
        if (null === $request) {
            // Instantiate default request object (HTTP version)
            $request = new Zend_Controller_Request_Http();
            $this->getFrontController()->setRequest($request);
        }
 
        $uri = ltrim((string) $request->getRequestUri(), '/');
        $tokens = explode('/', $uri);
 
        // TW: only load controller based routes for app
        if ($tokens[0] == 'app' && sizeof($tokens) > 1) {
        	// extract controller name
        	$filename = $tokens[1];
        } else {
        	// use default
        	$filename = 'default';
        }

        if ($filename !== '') {
            $path = rtrim((string) $path, '/\\');
            $this->_routesDirectory = $path;
            $this->addRoutesFromFile($path, $filename, $sections);
        }
        return $this;
    }
 
    /**
     * Return the path to the routes directory.
     *
     * @return null|string
     */
    public function getRoutesDirectory() 
    {
        return $this->_routesDirectory;
    }
 
 
    /**
     * Add routes from file
     * 
     * @param string $path
     * @param string $filename
     * @param array|null $sections
     * @return Zend_Controller_Router_Interface Rewrite object
     * @throws Zend_Controller_Router_Exception
     */
    public function addRoutesFromFile($path, $filename, $sections = null) 
    {
        $extension = 'ini';
        if (null === $sections) {
            $extension = 'php';
        }
        $file = $path . DIRECTORY_SEPARATOR . $filename . '.' . $extension;
        if (! file_exists($file)) {
            throw new Zend_Controller_Router_Exception('No such file or directory: ' . $file);
        }
 
        if ($extension === 'php') {
            include_once $file;
            if (isset($routes) && is_array($routes)) {
                $this->addRoutes($routes);
            }
        } else if ($extension === 'ini') {
            $fileSection = (array_key_exists(0, $sections)) ? $sections[0] : null;
            $propSection = (array_key_exists(1, $sections)) ? $sections[1] : 'routes';
            
            /** Zend_Config_Ini **/
            // [taz] Get the configuration file to be loaded.
            // The final true parameter turns on allowing config modifications.
            $config = new Zend_Config_Ini($file, $fileSection, true);
            
            // [taz] If test routes (used for development) aren't allowed, 
            // strip them out of the routes list.
           	if (!$this->_allowTestRoutes()) {
           		
           		$this->_stripOutTestRoutes($config);
           	}
            
            $this->addConfig($config, $propSection);
        }
 
        return $this;
    }
    
    
    
    
    
    
    
    /**
     * Ascertain whether to allow test routes.
     * 
     * Test routes are usually for developer testing purposes.
     * They are usually turned on for DEVELOPMENT environments and turned off for PRODUCTION.
     * 
     * This is configured using the the debug.allow_tests_routes parameter in config.ini.
     * 
     * @return boolean Whether to allow test routes in the current environment.
     */
    private function _allowTestRoutes()
    {
            // [taz] See if the main config file is already loaded, so we can tell whether to remove testing routes.
            $mainConfig = Zend_Registry::getInstance()->get('CONFIG');
            
            // [taz] If $mainConfig isn't set, disallow test routes by default.
            if (!$mainConfig) {
            	return false;
            }
            
            // [taz] Return the setting of debug.allow_test_routes.
            return $mainConfig->debug->allow_test_routes;  
    }
    
    
    
    
    	
    	
    	
    /**
     * Strip out test routes from the supplied configuration object.
     * 
     * Test routes are routes with names beginning with 'test', for example:
     * 
     * 		routes.test_update_listing_images.route = "/test/updatelistingimages/:listing_id"
     * 
     * Test routes are usually only for internal developer purposes only.
     * The purpose of this method is to make test routes unavailable on the production system.
     * 
     * @param Zend_Config $config The configuration object containing the routes.
     */
    private function _stripOutTestRoutes(&$config)
    {
		// [taz] Pull any routes with names starting with "test" out.
            
        $routes = $config->routes->toArray();
            
        foreach ($routes as $routeName => $routeSpec) {

        	if ('test' == substr($routeName, 0, 4)) {
            	unset($config->routes->$routeName);
            }
            	
        }	    	
    }
    
    
    
}